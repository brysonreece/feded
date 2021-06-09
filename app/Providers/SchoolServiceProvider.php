<?php

namespace App\Providers;

use App\Services\SchoolService;
use Illuminate\Support\ServiceProvider;

class SchoolServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('schools', fn() => new SchoolService);
        $this->app->bind(SchoolService::class, fn() => app('schools'));
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
