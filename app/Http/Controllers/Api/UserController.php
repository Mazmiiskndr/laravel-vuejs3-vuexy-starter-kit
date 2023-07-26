<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
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

    /**
     * Prepare success response.
     * @param  string $message
     * @param  mixed $data
     * @return \Illuminate\Http\Response
     */
    protected function successResponse(string $message, $data)
    {
        // Prepare response array with standard success status, HTTP 200 code, custom message, and the data to return.
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => $message,
            'results' => $data,
        ];

        // Convert the response array into a JSON response with HTTP 200 status code.
        return response()->json($response, 200);
    }

    /**
     * Prepare error response.
     * @param  string $message
     * @param  int $code
     * @return \Illuminate\Http\Response
     */
    protected function errorResponse(string $message, int $code)
    {
        // Prepare response array with standard error status, custom HTTP code and custom error message.
        $response = [
            'status' => 'error',
            'code' => $code,
            'message' => $message,
        ];

        // Convert the response array into a JSON response with custom HTTP status code.
        return response()->json($response, $code);
    }
}
