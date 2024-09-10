<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    public function sendResponse($result = null, $message = 'Successful'): JsonResponse
    {
        return Response::json([
            'data'    => $result,
            'message' => $message,
        ]);
    }

    public function sendError($error, $code = 404): JsonResponse
    {
        return Response::json([
            'message' => $error,
        ], $code);
    }
}
