<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

abstract class AppException extends Exception
{
    protected static int $statusCode = Response::HTTP_BAD_REQUEST;

    public function __construct(string $message = '', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code ?: static::$statusCode, $previous);
    }
}
