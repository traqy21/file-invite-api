<?php


namespace App\Repositories;


use App\Models\Transaction as Model;

class TransactionRepository extends Repository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}