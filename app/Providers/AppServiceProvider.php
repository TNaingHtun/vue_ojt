<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Dao Registration
        $this->app->bind('App\Contracts\Dao\Posts\PostDaoInterface', 'App\Dao\Posts\PostDao');
        $this->app->bind('App\Contracts\Dao\User\UserDaoInterface', 'App\Dao\User\UserDao');
        $this->app->bind('App\Contracts\Dao\User\ProfileDaoInterface', 'App\Dao\User\ProfileDao');

        // Business logic registration
        $this->app->bind('App\Contracts\Services\Posts\PostServiceInterface', 'App\Services\Posts\PostService');
        $this->app->bind('App\Contracts\Services\User\UserServiceInterface', 'App\Services\User\UserService');
        $this->app->bind('App\Contracts\Services\User\ProfileServiceInterface', 'App\Services\User\ProfileService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
