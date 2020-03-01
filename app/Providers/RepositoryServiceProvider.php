<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as Provider;

class RepositoryServiceProvider extends Provider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Interfaces\UserRepositoryInterface',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\Interfaces\PostRepositoryInterface',
            'App\Repositories\PostRepository'
        );

        $this->app->bind(
            'App\Repositories\Interfaces\SubscriberRepositoryInterface',
            'App\Repositories\SubscriberRepository'
        );
    }
}
