<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService
{

    /**
     * Get users with pagination, sorting and limit.
     * @param  string  $sort
     * @param  int  $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsers(string $sort = 'asc', int $limit = 10);
}
