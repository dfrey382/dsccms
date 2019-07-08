<?php

namespace Dsc\Providers;

use Carbon\Carbon;
use Dsc\Repositories\Activity\ActivityRepository;
use Dsc\Repositories\Activity\EloquentActivity;
use Dsc\Repositories\Country\CountryRepository;
use Dsc\Repositories\Country\EloquentCountry;
use Dsc\Repositories\Permission\EloquentPermission;
use Dsc\Repositories\Permission\PermissionRepository;
use Dsc\Repositories\Role\EloquentRole;
use Dsc\Repositories\Role\RoleRepository;
use Dsc\Repositories\Session\DbSession;
use Dsc\Repositories\Session\SessionRepository;
use Dsc\Repositories\User\EloquentUser;
use Dsc\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        config(['app.name' => settings('app_name')]);
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepository::class, EloquentUser::class);
        $this->app->singleton(ActivityRepository::class, EloquentActivity::class);
        $this->app->singleton(RoleRepository::class, EloquentRole::class);
        $this->app->singleton(PermissionRepository::class, EloquentPermission::class);
        $this->app->singleton(SessionRepository::class, DbSession::class);
        $this->app->singleton(CountryRepository::class, EloquentCountry::class);

        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
