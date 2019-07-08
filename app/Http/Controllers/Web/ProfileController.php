<?php

namespace Dsc\Http\Controllers\Web;

use Dsc\Events\User\ChangedAvatar;
use Dsc\Events\User\UpdatedProfileDetails;
use Dsc\Http\Controllers\Controller;
use Dsc\Http\Requests\User\UpdateProfileDetailsRequest;
use Dsc\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use Dsc\Repositories\Activity\ActivityRepository;
use Dsc\Repositories\Country\CountryRepository;
use Dsc\Repositories\Role\RoleRepository;
use Dsc\Repositories\Session\SessionRepository;
use Dsc\Repositories\User\UserRepository;
use Dsc\Role;
use Dsc\Services\Upload\UserAvatarManager;
use Dsc\Support\Enum\UserStatus;
use Dsc\User;
use Auth;
use Illuminate\Http\Request;

/**
 * Class ProfileController
 * @package Dsc\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @var User
     */
    protected $theUser;

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * UsersController constructor.
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);

        $this->users = $users;

        $this->middleware(function ($request, $next) {
            $this->theUser = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display user's profile page.
     *
     * @param RoleRepository $rolesRepo
     * @param CountryRepository $countryRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(RoleRepository $rolesRepo, CountryRepository $countryRepository)
    {
        $roles = $rolesRepo->all()->filter(function ($role) {
            return $role->id == $this->theUser->role_id;
        })->pluck('name', 'id');

        return view('user/profile', [
            'user' => $this->theUser,
            'edit' => true,
            'roles' => $roles,
            'countries' => [0 => 'Select a Country'] + $countryRepository->lists()->toArray(),
            'socialLogins' => $this->users->getUserSocialLogins($this->theUser->id),
            'statuses' => UserStatus::lists()
        ]);
    }

    /**
     * Update profile details.
     *
     * @param UpdateProfileDetailsRequest $request
     * @return mixed
     */
    public function updateDetails(UpdateProfileDetailsRequest $request)
    {
        $this->users->update($this->theUser->id, $request->except('role_id', 'status'));

        event(new UpdatedProfileDetails);

        return redirect()->back()
            ->withSuccess(trans('app.profile_updated_successfully'));
    }

    /**
     * Upload and update user's avatar.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatar(Request $request, UserAvatarManager $avatarManager)
    {
        $request->validate(['avatar' => 'image']);

        $name = $avatarManager->uploadAndCropAvatar(
            $this->theUser,
            $request->file('avatar'),
            $request->get('points')
        );

        if ($name) {
            return $this->handleAvatarUpdate($name);
        }

        return redirect()->route('profile')
            ->withErrors(trans('app.avatar_not_changed'));
    }

    /**
     * Update avatar for currently logged in user
     * and fire appropriate event.
     *
     * @param $avatar
     * @return mixed
     */
    private function handleAvatarUpdate($avatar)
    {
        $this->users->update($this->theUser->id, ['avatar' => $avatar]);

        event(new ChangedAvatar);

        return redirect()->route('profile')
            ->withSuccess(trans('app.avatar_changed'));
    }

    /**
     * Update user's avatar from external location/url.
     *
     * @param Request $request
     * @param UserAvatarManager $avatarManager
     * @return mixed
     */
    public function updateAvatarExternal(Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($this->theUser);

        return $this->handleAvatarUpdate($request->get('url'));
    }

    /**
     * Update user's login details.
     *
     * @param UpdateProfileLoginDetailsRequest $request
     * @return mixed
     */
    public function updateLoginDetails(UpdateProfileLoginDetailsRequest $request)
    {
        $data = $request->except('role', 'status');

        // If password is not provided, then we will
        // just remove it from $data array and do not change it
        if (trim($data['password']) == '') {
            unset($data['password']);

            unset($data['password_confirmation']);
        }

        $this->users->update($this->theUser->id, $data);

        return redirect()->route('profile')
            ->withSuccess(trans('app.login_updated'));
    }

    /**
     * Display user activity log.
     *
     * @param ActivityRepository $activitiesRepo
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activity(ActivityRepository $activitiesRepo, Request $request)
    {
        $user = $this->theUser;

        $activities = $activitiesRepo->paginateActivitiesForUser(
            $user->id,
            $perPage = 20,
            $request->get('search')
        );

        return view('activity.index', compact('activities', 'user'));
    }


    /**
     * Display active sessions for current user.
     *
     * @param SessionRepository $sessionRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sessions(SessionRepository $sessionRepository)
    {
        $profile = true;
        $user = $this->theUser;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('user.sessions', compact('sessions', 'user', 'profile'));
    }

    /**
     * Invalidate user's session.
     *
     * @param $session \stdClass Session object.
     * @param SessionRepository $sessionRepository
     * @return mixed
     */
    public function invalidateSession($session, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateSession($session->id);

        return redirect()->route('profile.sessions')
            ->withSuccess(trans('app.session_invalidated'));
    }
}
