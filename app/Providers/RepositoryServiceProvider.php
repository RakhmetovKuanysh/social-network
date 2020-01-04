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
    }
}