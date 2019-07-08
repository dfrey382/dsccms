<?php

namespace Dsc\Providers;

use Dsc\Events\User\Banned;
use Dsc\Events\User\LoggedIn;
use Dsc\Events\User\Registered;
use Dsc\Listeners\Users\InvalidateSessionsAndTokens;
use Dsc\Listeners\Login\UpdateLastLoginTimestamp;
use Dsc\Listeners\PermissionEventsSubscriber;
use Dsc\Listeners\Registration\SendConfirmationEmail;
use Dsc\Listeners\Registration\SendSignUpNotification;
use Dsc\Listeners\RoleEventsSubscriber;
use Dsc\Listeners\UserEventsSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendConfirmationEmail::class,
            SendSignUpNotification::class,
        ],
        LoggedIn::class => [
            UpdateLastLoginTimestamp::class
        ],
        Banned::class => [
            InvalidateSessionsAndTokens::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventsSubscriber::class,
        RoleEventsSubscriber::class,
        PermissionEventsSubscriber::class
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
