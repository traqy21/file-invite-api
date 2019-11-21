<?php

class CustomerTest extends TestCase {

    public function testRegisterCustomer() {
        $response = $this->post("customer/register", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'email',
            'password',
            'first_name',
            'last_name',
            'middle_initial',
            'contact_number',
        ]);

        $testdata = factory(\App\Models\Customer::class)->make();

        $response = $this->post("customer/register", [
            'email' => $testdata->email,
            'password' => $testdata->password,
            'first_name' => $testdata->first_name,
            'last_name' => $testdata->last_name,
            'middle_initial' => $testdata->middle_initial,
            'contact_number' => $testdata->contact_number,
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message'
        ]);
    }

    public function testLoginCustomer() {

        //register
        $testdata = factory(\App\Models\Customer::class)->make();
        $response = $this->post("customer/register", [
            'email' => $testdata->email,
            'password' => $testdata->password,
            'first_name' => $testdata->first_name,
            'last_name' => $testdata->last_name,
            'middle_initial' => $testdata->middle_initial,
            'contact_number' => $testdata->contact_number,
        ]);

        //login
        $response = $this->post("customer/login", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'email',
            'password'
        ]);

        $response = $this->post("customer/login", [
            'email' => $testdata->email,
            'password' => $testdata->password
        ]);
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message',
            'user'
        ]);
    }

    /*
      public function testviewSalesAgentByBrand() {

      //add 10 sale agents with same brand
      $brand = 'Toyota';
      for ($i = 0; $i < 10; $i++) {

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
      $response->assertResponseStatus(200);
      }

      //register customer
      $testdata = factory(\App\Models\Customer::class)->make();

      $response = $this->post("customer/register", [
      'email' => $testdata->email,
      'password' => $testdata->password,
      'first_name' => $testdata->first_name,
      'last_name' => $testdata->last_name,
      'middle_initial' => $testdata->middle_initial,
      'contact_number' => $testdata->contact_number,
      ]);
      $response->assertResponseStatus(200);

      //login customer
      $response = $this->post("customer/login", [
      'email' => $testdata->email,
      'password' => $testdata->password
      ]);
      $data = json_decode($response->response->getContent());
      $response->assertResponseStatus(200);


      //view sales agents with same brand
      //403
      $response = $this->post("customer/agent/view");
      $response->assertResponseStatus(403);
      //422
      $response = $this->post("customer/agent/view", [], $this->CustomerHeader($data->user));
      $response->assertResponseStatus(422);
      $response->seeJsonStructure([
      'brand',
      ]);

      //200
      $response = $this->post("customer/agent/view", [
      "brand" => $brand,
      ], $this->CustomerHeader($data->user));
      $response->assertResponseStatus(200);
      $response->seeJsonStructure([
      'message',
      'list' => [
      '*' => [
      'uuid',
      'first_name',
      'last_name',
      'middle_initial',
      'contact_number'
      ]
      ]
      ]);
      }

      public function testSearchSalesAgentByBranch() {
      //add 10 sale agents with same brand and branch
      $brand = 'Mitsubishi';
      $branch = 'Naga';
      for ($i = 0; $i < 10; $i++) {
      $testdata = factory(\App\Models\Agent::class)->make();
      $response = $this->post("agent/register", [
      'email' => $testdata->email,
      'password' => $testdata->password,
      'first_name' => $testdata->first_name,
      'last_name' => $testdata->last_name,
      'middle_initial' => $testdata->middle_initial,
      'contact_number' => $testdata->contact_number,
      'assigned_brand' => $brand,
      'assigned_branch' => $branch
      ]);
      $response->assertResponseStatus(200);
      }

      //register customer
      $testdata = factory(\App\Models\Customer::class)->make();

      $response = $this->post("customer/register", [
      'email' => $testdata->email,
      'password' => $testdata->password,
      'first_name' => $testdata->first_name,
      'last_name' => $testdata->last_name,
      'middle_initial' => $testdata->middle_initial,
      'contact_number' => $testdata->contact_number,
      ]);
      $response->assertResponseStatus(200);

      //login customer
      $response = $this->post("customer/login", [
      'email' => $testdata->email,
      'password' => $testdata->password
      ]);
      $data = json_decode($response->response->getContent());
      $response->assertResponseStatus(200);

      //view sales agents with same brand and branch
      //403
      $response = $this->post("customer/agent/search");
      $response->assertResponseStatus(403);

      //422
      $response = $this->post("customer/agent/search", [], $this->CustomerHeader($data->user));
      $response->assertResponseStatus(422);
      $response->seeJsonStructure([
      'brand',
      'branch'
      ]);

      //200
      $response = $this->post("customer/agent/search", [
      "brand" => $brand,
      "branch" => 'nag'
      ], $this->CustomerHeader($data->user));
      $response->assertResponseStatus(200);
      $response->seeJsonStructure([
      'message',
      'list' => [
      '*' => [
      'uuid',
      'first_name',
      'last_name',
      'middle_initial',
      'contact_number'
      ]
      ]
      ]);
      }

     */

    public function testviewSalesAgentByBrand() {
        
    }

}
