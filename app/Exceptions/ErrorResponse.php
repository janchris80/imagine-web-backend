<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResponse extends JsonResource
{
    /** @var string */
    public static $wrap = '';

    public string $message;

    /** @var mixed|null */
    public mixed $errors;

    public function __construct(
        string $message,
        mixed $errors = null,
        mixed $resource = null
    ) {
        $this->message = $message;
        $this->errors = $errors;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $response = [
            'message' => $this->message,
        ];

        if ($this->errors !== null) {
            $response['errors'] = $this->errors;
        }

        return $response;
    }
}
