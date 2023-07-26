<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository
{

    /**
     * Get users with pagination, sorting and limit.
     * @param  string  $sort
     * @param  int  $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsers(string $sort, int $limit);
}
