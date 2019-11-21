<?php

class BrandTest extends TestCase {

    //admin
    public function testAddBrand() {
        //403
        $response = $this->post("admin/brand/create", []);
        $response->assertResponseStatus(403);

        //422
        $user = factory(\App\Models\Admin::class)->make();
        $response = $this->post("admin/brand/create", [], $this->AdminHeader($user));
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'name',
            'category_uuid'
        ]);

        //200
        $category = factory(\App\Models\Category::class)->make();
        $brand = factory(\App\Models\Brand::class)->make();
        $response = $this->post("admin/brand/create", [
            'name' => $brand->name,
            'category_uuid' => $category->uuid
                ], $this->AdminHeader($user)
        );
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testBrandUpdate() {
        $user = factory(\App\Models\Admin::class)->make();
        $testdata = factory(\App\Models\Category::class)->make();
        $response = $this->post("admin/category/create", [
            'name' => $testdata->name,
                ], $this->AdminHeader($user)
        );
        $categoryObj = $this->decode($response);

        $brand = factory(\App\Models\Brand::class)->make();
        $response = $this->post("admin/brand/create", [
            'name' => 'Juan ' . $brand->name,
            'category_uuid' => $categoryObj->model->uuid,
                ], $this->AdminHeader($user)
        );
        $response->assertResponseStatus(200);

        $brandObj = $this->decode($response);

        //update
        //403
        $response = $this->post("admin/brand/update", []);
        $response->assertResponseStatus(403);

        //422
        $response = $this->post("admin/brand/update", [], $this->AdminHeader($user));
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'uuid',
            'name',
        ]);

        //200
        $testdata = factory(\App\Models\Brand::class)->make();
        $response = $this->post("admin/brand/update", [
            'uuid' => $brandObj->model->uuid,
            'name' => $testdata->name,
                ], $this->AdminHeader($user)
        );
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testBrandList() {

        $user = factory(\App\Models\Admin::class)->make();
        $testdata = factory(\App\Models\Category::class)->make();
        $response = $this->post("admin/category/create", [
            'name' => $testdata->name,
                ], $this->AdminHeader($user)
        );
        $categoryObj = $this->decode($response);

        for ($i = 0; $i < 5; $i++) {
            $brand = factory(\App\Models\Brand::class)->make();
            $response = $this->post("admin/brand/create", [
                'name' => 'Juan ' . $brand->name,
                'category_uuid' => $categoryObj->model->uuid,
                    ], $this->AdminHeader($user)
            );
            $response->assertResponseStatus(200);
        }

        $response = $this->post("admin/brand/list", [
            "category_uuid" => $categoryObj->model->uuid,
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
