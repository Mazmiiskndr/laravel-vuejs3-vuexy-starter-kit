<?php

namespace App\Services\User;

use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;
use App\Traits\HandleRepositoryCall;

class UserServiceImplement extends Service implements UserService
{
  use HandleRepositoryCall;
  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(UserRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  /**
   * Get users with pagination, sorting and limit.
   * @param  string  $sort
   * @param  int  $limit
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function getUsers(string $sort = 'asc', int $limit = 10)
  {
    return $this->handleRepositoryCall('getUsers', [$sort, $limit]);
  }
}
