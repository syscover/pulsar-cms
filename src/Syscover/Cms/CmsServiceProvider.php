<?php namespace Syscover\Admin;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	    // register routes
        if (!$this->app->routesAreCached())
            require __DIR__ . '/../../routes/api.php';

        // register migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations/' => base_path('/database/migrations'),
        ], 'migrations');

        // register seeds
        $this->publishes([
            __DIR__ . '/../../database/seeds/' => base_path('/database/seeds')
        ], 'seeds');

        // register tests
        $this->publishes([
            __DIR__ . '/../../tests/Feature/' => base_path('/tests/Feature')
        ], 'tests');

        // register config files
        $this->publishes([
            __DIR__ . '/../../config/pulsar.cms.php' => config_path('pulsar.cms.php'),
        ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        //
	}
}