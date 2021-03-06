<?php namespace BibleExperience\Providers;

use Illuminate\Support\ServiceProvider;
use \Auth0;
//use \BibleExperience\Observers\UserObserver;
//use \BibleExperience\User;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//User::observe(UserObserver::class);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(
			'Illuminate\Contracts\Auth\Registrar',
			'BibleExperience\Services\Registrar'
		);
		
		$this->app->singleton('path.public',function(){
			return base_path().'/../public_html';
		});
		
        //
        $this->app->bind(
        '\Auth0\Login\Contract\Auth0UserRepository',
        '\Auth0\Login\Repository\Auth0UserRepository');

  }
}
