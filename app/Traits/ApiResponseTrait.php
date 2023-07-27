<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Prepare success response.
     * @param  string $message
     * @param  mixed $data
     * @return \Illuminate\Http\Response
     */
    public function successResponse(string $message, $data)
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
    public function errorResponse(string $message, int $code)
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
