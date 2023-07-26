<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Get users with pagination, sorting and limit.
     * @param  string  $sort
     * @param  int  $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsers(string $sort = 'asc', int $limit = 10)
    {
        return $this->model->orderBy('id', $sort)->paginate($limit);
    }
}
