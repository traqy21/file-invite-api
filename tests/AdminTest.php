<?php

class AdminTest extends TestCase {

    public function testRegisterAdmin() {
        $response = $this->post("admin/register", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'username',
            'password',
        ]);

        $testdata = factory(\App\Models\Admin::class)->make();
        $response = $this->post("admin/register", [
            'username' => $testdata->username,
            'password' => $testdata->password,
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testLoginAdmin() {
        //register
        $testdata = factory(\App\Models\Admin::class)->make();
        $response = $this->post("admin/register", [
            'username' => $testdata->username,
            'password' => $testdata->password,
        ]);

        //login
        //test 422
        $response = $this->post("admin/login", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'username',
            'password'
        ]);

        //test 200
        $response = $this->post("admin/login", [
            'username' => $testdata->username,
            'password' => $testdata->password
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message',
            'user'
        ]);
    }

}
