<?php

namespace Dsc\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Dsc\Http\Middleware\VerifyInstallation::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Dsc\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \Dsc\Http\Middleware\TrustProxies::class,
    ];
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Dsc\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Dsc\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            \Dsc\Http\Middleware\UseApiGuard::class,
            'throttle:60,1',
            'bindings'
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Dsc\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Dsc\Http\Middleware\RedirectIfAuthenticated::class,
        'registration' => \Dsc\Http\Middleware\Registration::class,
        'social.login' => \Dsc\Http\Middleware\SocialLogin::class,
        'role' => \Dsc\Http\Middleware\CheckRole::class,
        'permission' => \Dsc\Http\Middleware\CheckPermissions::class,
        'session.database' => \Dsc\Http\Middleware\DatabaseSession::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'verify-2fa-phone' => \Dsc\Http\Middleware\VerifyTwoFactorPhone::class
    ];
}
