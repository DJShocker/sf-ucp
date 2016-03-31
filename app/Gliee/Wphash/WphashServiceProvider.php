<?php namespace Gliee\Wphash;

use Illuminate\Support\ServiceProvider;

class WphashServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	    $this->app['wphash'] = $this->app->share(function($app)
	    {
	        return new Wphash;
	    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
