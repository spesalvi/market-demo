<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StoredValueProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
	$this->app->singleton('\SV', function($app) {
		return new \stdClass;
	});
        //
    }
}

