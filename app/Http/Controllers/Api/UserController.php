<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * This trait provides common functionality for handling API responses.
     */
    use ApiResponseTrait;

    /**
     * The instance of the UserService class.
     * @var UserService
     */
    protected $userService;

    /**
     * Constructs a new instance of the class.
     * @param UserService $userService The user service dependency.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Get validated parameters
            [$sort, $limit] = $this->getValidatedParams($request);

            // Query the users through UserService
            $users = $this->userService->getUsers($sort, $limit);

            // If no users found, return error response
            if ($users->isEmpty()) {
                return $this->errorResponse('No users found.', 404);
            }

            // Return the success response
            return $this->successResponse('Data fetched successfully.', $users);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to fetch users: ' . $e->getMessage());

            // Return error response
            return $this->errorResponse('Failed to fetch users.', 500);
        }
    }

    /**
     * Get validated request parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getValidatedParams(Request $request)
    {
        // Fetch 'sort' query parameter, if it doesn't exist default is 'asc'.
        $sort = $request->query('sort', 'asc');
        // Ensure 'sort' value is either 'asc' or 'desc', otherwise default to 'asc'.
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'asc';
        // Fetch 'limit' query parameter, if it doesn't exist default is 10.
        $limit = (int) $request->query('limit', 10);
        // Ensure 'limit' value is between 1 and 100, otherwise limit to min or max bounds.
        $limit = max(1, min(100, $limit));

        // Return both 'sort' and 'limit' values.
        return [$sort, $limit];
    }
}
