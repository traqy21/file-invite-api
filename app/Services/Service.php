<?php

namespace App\Services;

use App\Repositories\Repository;
use App\Models\Model;

abstract class Service {

    protected $repository;
    protected $module = 'default';

    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    public function create($data) {
        return (object) [
                    "status" => 200,
                    "message" => __("messages.{$this->module}.create.200"),
                    "model" => $this->repository->create($data)
        ];
    }

    public function update(Model $model, $data) {
        return (object) [
                    "status" => 200,
                    "message" => __("messages.{$this->module}.update.200"),
                    "model" => $this->repository->update($model, $data),
        ];
    }

    public function delete(Model $model) {
        $delete = $this->repository->delete($model);
        if ($delete) {
            return (object) [
                        "status" => 200,
                        "message" => __("messages.{$this->module}.delete.200")
            ];
        }

        return (object) [
                    "status" => 400,
                    "message" => __("messages.{$this->module}.delete.400")
        ];
    }

    public function view(Model $model) {
        return $this->repository->view($model);
    }

    public function find($field, $id) {
        return $this->repository->find($field, $id);
    }

    public function findBy($field, $value, $columns) {

        $collection = $this->repository->findBy($field, $value, $columns);
        return (object) [
                    "status" => 200,
                    "message" => __("messages.{$this->module}.view.200"),
                    "list" => $collection
        ];
    }

}
