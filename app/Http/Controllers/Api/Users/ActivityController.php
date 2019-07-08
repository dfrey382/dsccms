<?php

namespace Dsc\Http\Controllers\Api\Users;

use Dsc\Http\Controllers\Api\ApiController;
use Dsc\Http\Requests\Activity\GetActivitiesRequest;
use Dsc\Repositories\Activity\ActivityRepository;
use Dsc\Transformers\ActivityTransformer;
use Dsc\User;

/**
 * Class ActivityController
 * @package Dsc\Http\Controllers\Api\Users
 */
class ActivityController extends ApiController
{
    /**
     * @var ActivityRepository
     */
    private $activities;

    public function __construct(ActivityRepository $activities)
    {
        $this->middleware('auth');
        $this->middleware('permission:users.activity');

        $this->activities = $activities;
    }

    /**
     * Get activities for specified user.
     * @param User $user
     * @param GetActivitiesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(User $user, GetActivitiesRequest $request)
    {
        $activities = $this->activities->paginateActivitiesForUser(
            $user->id,
            $request->per_page ?: 20,
            $request->search
        );

        return $this->respondWithPagination(
            $activities,
            new ActivityTransformer
        );
    }
}
