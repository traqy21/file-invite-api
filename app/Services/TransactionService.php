<?php


namespace App\Services;


use App\Repositories\TransactionRepository as Repository;

class TransactionService extends Service
{
    protected $module = "transaction";

    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

}