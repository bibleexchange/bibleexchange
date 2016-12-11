<?php namespace BibleExperience\Providers;

use Illuminate\Routing\Router;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'BibleExperience\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

		//
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router, Request $request)
	{
		
		if ($request->has('lang'))
		{
			$locale = $request->input('lang');
			\Session::put('language_preference', $locale);
			$this->app->setLocale($locale);
		}else if(\Session::get('language_preference') != null){
			$this->app->setLocale(\Session::get('language_preference'));
		}
		
		
		
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}

}
