<?php

namespace App\Http\Controllers\API\V1\Users;

use App\Actions\Users\ChangePassword;
use App\Actions\Users\UpdateUser;
use App\Exceptions\SuccessResponse;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Users\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiBaseController
{
    /**
     * Show the authenticated user's details.
     */
    public function show(): SuccessResponse
    {
        return SuccessResponse::make([
            'data' => new UserResource(Auth::user()),
        ]);
    }

    /**
     * Update the authenticated user's details.
     */
    public function update(UpdateUserRequest $request, UpdateUser $updateUser): SuccessResponse
    {
        $updateUser(
            user: $request->user(),
            name: $request->input('name'),
            email: $request->input('email')
        );

        return SuccessResponse::make([
            'data' => new UserResource(Auth::user()->fresh()),
        ]);
    }

    /**
     * Change the authenticated user's password.
     */
    public function changePassword(ChangePasswordRequest $request, ChangePassword $changePassword): SuccessResponse
    {
        $changePassword(
            user: $request->user(),
            password: $request->input('password')
        );

        return SuccessResponse::make();
    }
}
