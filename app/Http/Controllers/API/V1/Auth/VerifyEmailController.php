<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerifyEmailController extends ApiBaseController
{
    public function __invoke(EmailVerificationRequest $request): JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->sendResponse([
                'status' => 'email-already-verified',
            ]);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->sendResponse([
            'status' => 'email-verified',
        ]);
    }
}
