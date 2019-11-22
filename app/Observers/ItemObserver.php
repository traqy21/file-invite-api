<?php


namespace App\Observers;


use App\Models\Item;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Log;

class ItemObserver
{
    protected $service;
    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function created(Item $item) {
        $this->service->create([
            "message" => "Item {$item->name} was created."
        ]);
    }

    public function deleted(Item $item) {
        $this->service->create([
            "message" => "Item {$item->name} was deleted."
        ]);
    }

    public function updated(Item $item) {
        if($item->is_completed){
            $this->service->create([
                "message" => "Item {$item->name} was completed."
            ]);
        } else {
            $this->service->create([
                "message" => "Item {$item->name} was not completed."
            ]);
        }
    }

}