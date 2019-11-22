<?php


namespace App\Repositories;


use App\Models\Item as Model;

class ItemRepository extends Repository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}