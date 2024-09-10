<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Auth\ResetPasswordController;
use App\Http\Controllers\API\V1\Auth\SendEmailVerificationNotificationController;
use App\Http\Controllers\API\V1\Auth\SendPasswordResetLinkController;
use App\Http\Controllers\API\V1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'v1/auth',
    'as'     => 'api.v1.auth.',
], function () {
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/refresh', [AuthController::class, 'refresh'])
        ->name('refresh');

    Route::post('/forgot-password', SendPasswordResetLinkController::class)
        ->name('password.email');

    Route::post('/reset-password', ResetPasswordController::class)
        ->name('password.update');

    Route::middleware('auth:api')->group(function () {
        Route::post('/email/verification-notification', SendEmailVerificationNotificationController::class)
            ->middleware(['throttle:6,1'])
            ->name('verification.send');

        Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });
});
