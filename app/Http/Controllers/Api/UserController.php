<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

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
            if ($request->ajax()) {
                $data = User::latest()->get();
                return Datatables::of($data)
                    ->addColumn('created_at', function ($row) {
                        return date('d-m-Y', strtotime($row->created_at));
                    })
                    ->addColumn('updated_at', function ($row) {
                        return date('d-m-Y', strtotime($row->updated_at));
                    })
                    ->addIndexColumn()
                    ->make(true);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to fetch users: ' . $e->getMessage());

            // Return error response
            return $this->errorResponse('Failed to fetch users.', 500);
        }
    }

    /**
     * Display the specified user.
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Get the user from the UserService
            $user = $this->userService->getUser($id);

            // If no user found, return error response
            if (!$user) {
                return $this->errorResponse('User not found.', 404);
            }

            // Return the success response
            return $this->successResponse('Data fetched successfully.', $user);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to fetch user: ' . $e->getMessage());

            // Return error response
            return $this->errorResponse('Failed to fetch user.', 500);
        }
    }
}
