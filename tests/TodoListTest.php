<?php

class TodoListTest extends TestCase {

    public function testAddItem() {

        $response = $this->post("item/add", []);
        $response->assertResponseStatus(422);
        $response->seeJsonStructure([
            'name',
        ]);

        $response = $this->post("item/add", [
            "name" => str_random(5)
        ]);

        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'message',
        ]);
    }

    public function testDeleteItem(){

        //add item
        $response = $this->post("item/add", [
            "name" => str_random(5)
        ]);
        $addedItem = $this->decode($response);

        //delete
        $response = $this->get("item/delete/{$addedItem->data->uuid}");
        $response->assertResponseStatus(200);
    }

    public function testCompleteItem(){
        //add item
        $response = $this->post("item/add", [
            "name" => str_random(5)
        ]);
        $addedItem = $this->decode($response);

        $response = $this->get("item/complete/{$addedItem->data->uuid}");
        $response->assertResponseStatus(200);
    }

    public function testIncompleteItem(){
        //add item
        $response = $this->post("item/add", [
            "name" => str_random(5)
        ]);
        $addedItem = $this->decode($response);

        //set to completed
        $response = $this->get("item/complete/{$addedItem->data->uuid}");

        //set to incomplete
        $response = $this->get("item/incomplete/{$addedItem->data->uuid}");
        $response->assertResponseStatus(200);
    }


    public function testIncompleteList() {

        /* 200 */
        $response = $this->get("item/list/incomplete");
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'list' => [
                '*' => [
                    "name",
                    "uuid",
                ]
            ],
        ]);
    }

    public function testCompletedList() {

        /* 200 */
        $response = $this->get("item/list/completed");
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'list' => [
                '*' => [
                    "name",
                    "uuid",
                ]
            ],
        ]);
    }

    public function testTransactionLogs() {

        /* 200 */
        $response = $this->get("transaction/logs"); 
        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'list' => [
                '*' => [
                    "message",
                    "id",
                    "created_at"
                ]
            ],
        ]);
    }


}
