<?php

class AgentTest extends TestCase {

    public function testRegisterAgent() {

        //add dependencies
        $category = factory(\App\Models\Category::class)->make();
        $category->save();

        $admin = factory(\App\Models\Admin::class)->make();
        $brand = factory(\App\Models\Brand::class)->make();
        $response = $this->post("admin/brand/create", [
            'name' => $brand->name,
            'category_uuid' => $category->uuid
                ], $this->AdminHeader($admin)
        );

        $brandObj = $this->decode($response);

        $branch = factory(\App\Models\Branch::class)->make();
        $response = $this->post("admin/branch/create", [
            'name' => $branch->name,
            'address' => $branch->address,
            'brand_uuid' => $brandObj->model->uuid
                ], $this->AdminHeader($admin)
        );

        $branchObj = $this->decode($response);
        // test
        $response = $this->post("agent/register", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'email',
            'password',
            'first_name',
            'last_name',
            'middle_initial',
            'contact_number',
            'branch_uuid',
        ]);

        $agent = factory(\App\Models\Agent::class)->make();
        $response = $this->post("agent/register", [
            'email' => $agent->email,
            'password' => $agent->password,
            'first_name' => $agent->first_name,
            'last_name' => $agent->last_name,
            'middle_initial' => $agent->middle_initial,
            'contact_number' => $agent->contact_number,
            'branch_uuid' => $branchObj->model->uuid
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testLoginAgent() {

        //register
        $testdata = factory(\App\Models\Agent::class)->make();
        $response = $this->post("agent/register", [
            'email' => $testdata->email,
            'password' => 'password',
            'first_name' => $testdata->first_name,
            'last_name' => $testdata->last_name,
            'middle_initial' => $testdata->middle_initial,
            'contact_number' => $testdata->contact_number,
            'branch_uuid' => $testdata->branch_uuid
        ]);

        //login
        $response = $this->post("agent/login", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'email',
            'password'
        ]);

        $response = $this->post("agent/login", [
            'email' => $testdata->email,
            'password' => 'password'
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message',
            'user'
        ]);
    }

    public function testUploadPricelist() {

        //register agent
        $testdata = factory(\App\Models\Agent::class)->make();
        $response = $this->post("agent/register", [
            'email' => $testdata->email,
            'password' => $testdata->password,
            'first_name' => $testdata->first_name,
            'last_name' => $testdata->last_name,
            'middle_initial' => $testdata->middle_initial,
            'contact_number' => $testdata->contact_number,
            'branch_uuid' => $testdata->branch_uuid
        ]);

        //login agent
        $response = $this->post("agent/login", []);
        $response->assertResponseStatus(422);

        $response = $this->post("agent/login", [
            'email' => $testdata->email,
            'password' => $testdata->password
        ]);
        $data = json_decode($response->response->getContent());
        $response->assertResponseStatus(200);

        //agent upload pricelist
        //403
        $response = $this->post("agent/upload/pricelist");
        $response->assertResponseStatus(403);

        //422
        $response = $this->post("agent/upload/pricelist", [], $this->AgentHeader($data->user));
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'file',
        ]);

        //200
        $response = $this->post("agent/upload/pricelist", [
            "file" => base64_encode(file_get_contents(storage_path('test/toyota-pricelist.pdf'))),
                ], $this->AgentHeader($data->user));
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message',
        ]);
    }

}
