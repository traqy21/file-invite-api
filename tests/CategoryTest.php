<?php

class CategoryTest extends TestCase {

    //admin
    public function testAddCategory() {
        //403
        $response = $this->post("admin/category/create", []);
        $response->assertResponseStatus(403);

        //422
        $user = factory(\App\Models\Admin::class)->make();
        $response = $this->post("admin/category/create", [], $this->AdminHeader($user));
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'name',
        ]);

        //200
        $testdata = factory(\App\Models\Category::class)->make();
        $response = $this->post("admin/category/create", [
            'name' => $testdata->name,
                ], $this->AdminHeader($user)
        );
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testCategoryUpdate() {
        $user = factory(\App\Models\Admin::class)->make();
        $testdata = factory(\App\Models\Category::class)->make();
        $response = $this->post("admin/category/create", [
            'name' => $testdata->name,
                ], $this->AdminHeader($user)
        );
        $categoryObj = $this->decode($response);
        $response->assertResponseStatus(200);

        //update
        //403
        $response = $this->post("admin/category/update", []);
        $response->assertResponseStatus(403);

        //422
        $user = factory(\App\Models\Admin::class)->make();
        $response = $this->post("admin/category/update", [], $this->AdminHeader($user));
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'uuid',
            'name',
        ]);

        //200
        $testdata = factory(\App\Models\Category::class)->make();
        $response = $this->post("admin/category/update", [
            'uuid' => $categoryObj->model->uuid,
            'name' => $testdata->name,
                ], $this->AdminHeader($user)
        );
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testCategoryList() {
        //add
        $user = factory(\App\Models\Admin::class)->make();
        for ($i = 0; $i < 10; $i++) {
            $testdata = factory(\App\Models\Category::class)->make();
            $response = $this->post("admin/category/create", [
                'name' => "Juan {$testdata->name}",
                    ], $this->AdminHeader($user)
            );
        }

//        // TEST 403
//        $response = $this->post("admin/category/list/1000");
//        $response->assertResponseStatus(403);
//        $response->seeJsonStructure([
//            "message"
//        ]);
//
//
//        // TEST 404
//        $response = $this->post("admin/category/list/1000", [], $this->AdminHeader($user));
//        $response->assertResponseStatus(404);
        // TEST 200
        $response = $this->post("admin/category/list", [
            "keyword" => "Juan"
                ], $this->AdminHeader($user));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            "message",
            "list" => [
                "*" => [
                    'name'
                ]
            ],
            "max_page",
            "next_page",
            "prev_page",
        ]);
    }

}
