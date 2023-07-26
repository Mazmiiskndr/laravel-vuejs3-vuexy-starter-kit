<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get the 'sort' query parameter. Default is 'asc'
        $sort = $request->query('sort', 'asc');

        // Ensure 'sort' is either 'asc' or 'desc'
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'asc';
        }

        // Get the 'limit' query parameter. Default is 10
        $limit = (int) $request->query('limit', 10);

        // Ensure 'limit' is between 1 and 100
        $limit = max(1, min(100, $limit));

        // Query the users
        $users = User::orderBy('id', $sort)
            ->paginate($limit);

        // If no users found, return error response
        if ($users->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'No users found.',
            ], 404);
        }

        // Prepare the response
        $response = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Data fetched successfully.',
            'data' => $users,
        ];

        // Return the paginated results
        return response()->json($response, 200);
    }
}
