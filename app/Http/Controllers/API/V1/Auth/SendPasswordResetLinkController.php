<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendPasswordResetLinkRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class SendPasswordResetLinkController extends ApiBaseController
{
    public function __invoke(SendPasswordResetLinkRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return $this->sendResponse([
            'status' => __($status),
        ]);
    }
}
