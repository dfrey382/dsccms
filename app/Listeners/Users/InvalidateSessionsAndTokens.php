<?php

namespace Dsc\Listeners\Users;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Dsc\Events\User\Banned;
use Dsc\Events\User\LoggedIn;
use Dsc\Repositories\Session\SessionRepository;
use Dsc\Repositories\User\UserRepository;
use Dsc\Services\Auth\Api\Token;

class InvalidateSessionsAndTokens
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    public function __construct(SessionRepository $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Handle the event.
     *
     * @param Banned $event
     * @return void
     */
    public function handle(Banned $event)
    {
        $user = $event->getBannedUser();

        $this->sessions->invalidateAllSessionsForUser($user->id);

        Token::where('user_id', $user->id)->delete();
    }
}
