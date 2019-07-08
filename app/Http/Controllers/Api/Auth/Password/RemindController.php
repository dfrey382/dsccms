<?php

namespace Dsc\Http\Controllers\Api\Auth\Password;

use Dsc\Events\User\RequestedPasswordResetEmail;
use Dsc\Http\Controllers\Api\ApiController;
use Dsc\Http\Requests\Auth\PasswordRemindRequest;
use Dsc\Notifications\ResetPassword;
use Dsc\Repositories\User\UserRepository;
use Password;

class RemindController extends ApiController
{
    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PasswordRemindRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\Response
     */
    public function index(PasswordRemindRequest $request, UserRepository $users)
    {
        $user = $users->findByEmail($request->email);

        $token = Password::getRepository()->create($user);

        $user->notify(new ResetPassword($token));

        event(new RequestedPasswordResetEmail($user));

        return $this->respondWithSuccess();
    }
}
