<?php

namespace App\Http\Middleware;

use App\Exceptions\AppException;
use App\Exceptions\ErrorResponse;
use Closure;
use Illuminate\Http\JsonResponse;

class HandleExceptions
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (AppException $e) {
            return $this->makeErrorResponse($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            return $this->makeErrorResponse('Server error.', 500, $e);
        }
    }

    protected function makeErrorResponse(string $message, int $code, ?\Exception $exception = null): JsonResponse
    {
        $response = new ErrorResponse($message, $exception ? [
            'exception' => $exception->getMessage(),
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'trace'     => $exception->getTraceAsString(),
        ] : null);

        return $response->response()->setStatusCode($code);
    }
}
