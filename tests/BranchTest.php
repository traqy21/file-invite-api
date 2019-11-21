<?php

class BranchTest extends TestCase {

    //admin
    public function testAddBranch() {
        //403
        $response = $this->post("admin/branch/create", []);
        $response->assertResponseStatus(403);

        //422
        $user = factory(\App\Models\Admin::class)->make();
        $response = $this->post("admin/branch/create", [], $this->AdminHeader($user));
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'name',
            'address',
            'brand_uuid'
        ]);

        //200
        $branch = factory(\App\Models\Branch::class)->make();
        $response = $this->post("admin/branch/create", [
            'name' => $branch->name,
            'address' => $branch->address,
            'brand_uuid' => $branch->brand_uuid
                ], $this->AdminHeader($user)
        );
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

}
