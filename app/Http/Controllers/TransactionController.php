<?php


namespace App\Http\Controllers;


use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $service;
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function logs(){
        $result = $this->service->getAll(["id", "message", "created_at"]);
        return response()->json([
            "message" => $result->message,
            "list" => $result->list
        ], $result->status);
    }
}