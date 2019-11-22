<?php


namespace App\Services;


use App\Repositories\ItemRepository as Repository;

class ItemService extends Service
{
    protected $module = 'item';
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}