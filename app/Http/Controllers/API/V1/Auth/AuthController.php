<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Actions\Users\CreateUser;
use App\Exceptions\SuccessResponse;
use App\Exceptions\TokenException;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends ApiBaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request, CreateUser $createUser): SuccessResponse
    {
        $user = $createUser(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
            role: $request->input('role')
        );

        $credentials = $request->only(['email', 'password']);
        $rememberMe = $request->input('remember_me', false);

        $token = $this->authService->attemptLogin($credentials, $rememberMe);

        return SuccessResponse::make([
            'user'         => new UserResource($user),
            'access_token' => $token,
        ]);
    }

    /**
     * @throws TokenException
     */
    public function login(LoginRequest $request): SuccessResponse|JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        $rememberMe = $request->input('remember_me', false);

        $token = $this->authService->attemptLogin($credentials);

        return SuccessResponse::make([
            'user'         => new UserResource(auth()->user()),
            'access_token' => $token,
        ]);
    }

    public function logout(): Response
    {
        $this->authService->logout();

        return response()->noContent();
    }

    public function refresh(): SuccessResponse
    {
        $token = $this->authService->refreshToken();

        return SuccessResponse::make([
            'access_token' => $token,
        ]);
    }
}
