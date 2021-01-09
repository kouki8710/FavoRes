<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UuidV4Factory;

class UuidServoceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind("uuidFactory", UuidV4Factory::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

