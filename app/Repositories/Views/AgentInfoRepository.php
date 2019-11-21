<?php

namespace App\Repositories\Views;

use App\Models\Views\AgentInfo as Model;
use App\Repositories\Repository;

class AgentInfoRepository extends Repository {

    public function __construct(Model $model) {
        $this->model = $model;
    }

}
