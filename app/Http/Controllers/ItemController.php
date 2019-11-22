<?php


namespace App\Http\Controllers;


use App\Services\ItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    protected $service;
    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    public function add(Request $request){
        $this->validate($request, [
            "name" => "required"
        ]);

        $result = $this->service->create($request->all());
        return response()->json([
            "message" => $result->message,
            "data" => $result->model
        ], $result->status);
    }

    public function delete($uuid){
        $model = $this->service->find("uuid", $uuid);
        $result = $this->service->delete($model);
        return response()->json([
            "message" => $result->message,
        ], $result->status);
    }

    public function complete($uuid){
        $model = $this->service->find("uuid", $uuid);
        $result = $this->service->update($model, [
            "is_completed" => true
        ]);
        return response()->json([
            "message" => $result->message,
        ], $result->status);
    }

    public function incomplete($uuid){
        $model = $this->service->find("uuid", $uuid);
        $result = $this->service->update($model, [
            "is_completed" => false
        ]);
        return response()->json([
            "message" => $result->message,
        ], $result->status);
    }

    public function incompleteList(){
        $result = $this->service->findAllByOrderBy("is_completed",0, ['uuid', 'name']);
        return response()->json([
            "message" => $result->message,
            "list" => $result->list
        ], $result->status);
    }


    public function completedList(){
        $result = $this->service->findAllByOrderBy("is_completed",1, ['uuid', 'name']);
        return response()->json([
            "message" => $result->message,
            "list" => $result->list
        ], $result->status);
    }


}