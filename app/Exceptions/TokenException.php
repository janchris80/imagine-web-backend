<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TokenException extends AppException
{
    /**
     * Create a new token exception instance.
     */
    public function __construct(string $message = 'Token error', int $code = Response::HTTP_UNAUTHORIZED, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
