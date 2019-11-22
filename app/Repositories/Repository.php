<?php

namespace App\Repositories;

use App\Models\Model;
use Ramsey\Uuid\Uuid;

abstract class Repository {

    const PERPAGE = 25;
    const APPENDS = [];
    const WITH = [];

    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    /**
     * Create of the model function
     *
     * @param $data
     * @return object
     */
    public function create($data) {
        $data['uuid'] = Uuid::uuid4()->toString();
        return $this->model->create($data);
    }

    /**
     * Updating of the model
     *
     * @param Model $model
     * @param $data
     * @return object
     */
    public function update(Model $model, $data) {
        $model->fill($data)->save();
        $model->append(static::APPENDS);
        return $model;
    }

    /**
     * Deletion of the model
     *
     * @param Model $model
     * @return object
     */
    public function delete(Model $model) {
        if ($model->deletable) {
            $model->delete();
            return true;
        }
        return false;
    }

    /**
     * View Details
     *
     * @param Model $model
     * @return $this
     */
    public function view(Model $model) {
        return $model->append(static::APPENDS);
    }

    /**
     * Find by ID
     *
     * @param $field
     * @param $id
     * @return mixed
     */
    public function find($field, $id) {
        return $this->model->where($field, $id)->first();
    }

    /**
     * Find by value
     *
     * @param $field
     * @param $value
     * @param $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns) {
        return $this->model->where($field, $value)->get($columns);
    }

    /**
     * Find all
     *
     * @param $field
     * @param $value
     * @param $columns
     * @return mixed
     */
    public function findAll() {
        return $this->model->get();
    }

    public function findAllBy($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    public function findAllByOrderBy($attribute, $value, $columns = array('*'), $orderByField = 'id', $orderBy = 'asc') {
        return $this->model->where($attribute, '=', $value)
            ->orderBy($orderByField, $orderBy)
            ->get($columns);
    }

}
