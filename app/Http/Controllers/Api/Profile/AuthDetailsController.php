<?php

namespace Dsc\Http\Controllers\Api\Profile;

use Dsc\Events\User\UpdatedProfileDetails;
use Dsc\Http\Controllers\Api\ApiController;
use Dsc\Http\Requests\User\UpdateProfileDetailsRequest;
use Dsc\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use Dsc\Repositories\User\UserRepository;
use Dsc\Transformers\UserTransformer;

/**
 * Class DetailsController
 * @package Dsc\Http\Controllers\Api\Profile
 */
class AuthDetailsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Updates user profile details.
     * @param UpdateProfileLoginDetailsRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileLoginDetailsRequest $request, UserRepository $users)
    {
        $user = $request->user();

        $data = $request->only(['email', 'username', 'password']);

        $user = $users->update($user->id, $data);

        return $this->respondWithItem($user, new UserTransformer);
    }
}
