<?php

namespace Dsc\Listeners\Registration;

use Illuminate\Support\Str;
use Dsc\Events\User\Registered;
use Dsc\Notifications\EmailConfirmation;
use Dsc\Repositories\User\UserRepository;

class SendConfirmationEmail
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if (! settings('reg_email_confirmation')) {
            return;
        }

        $user = $event->getRegisteredUser();

        $token = Str::random(60);
        $this->users->update($user->id, [
            'confirmation_token' => $token
        ]);

        $user->notify(new EmailConfirmation($token));
    }
}
