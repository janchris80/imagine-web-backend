<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (AppException $e): JsonResponse {
            return $this->makeErrorResponse(
                $e->getCode(),
                $e->getMessage()
            );
        });
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  Request  $request
     */
    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        $statusCode = ($e instanceof HttpExceptionInterface) ? $e->getStatusCode() : 500;
        if (config('app.debug')) {
            return $this->makeErrorResponse(
                code: $statusCode,
                message: $e->getMessage(),
                errors: $this->convertExceptionToArray($e),
            );
        }

        return $this->makeErrorResponse(
            code: $statusCode,
            message: 'Server error.',
        );
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  Request  $request
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return $this->makeErrorResponse(
            code: $exception->status,
            message: $exception->getMessage(),
            errors: $exception->errors()
        );
    }

    protected function makeErrorResponse(
        int $code,
        string $message = 'Bad request',
        ?array $errors = null,
        mixed $data = null
    ): JsonResponse {
        return (new ErrorResponse($message, $errors, $data))->response()->setStatusCode($code);
    }
}
