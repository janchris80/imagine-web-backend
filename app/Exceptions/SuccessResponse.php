<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResponse extends JsonResource
{
    public string $message;

    /**
     * Success response constructor.
     */
    public function __construct(mixed $resource = null, string $message = 'Successful')
    {
        $this->message = $message;
        parent::__construct($resource);
    }

    /**
     * Customize the additional data to be returned with the resource array.
     *
     * @param  Request  $request
     */
    public function with($request): array
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return parent::toArray($request);
    }
}
