<?php namespace BibleExperience\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'BibleExperience\Http\Middleware\VerifyCsrfToken',
		'Barryvdh\Cors\HandleCors',
		
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'BibleExperience\Http\Middleware\Authenticate',
		'auth.viewer' => 'BibleExperience\Http\Middleware\AuthenticateViewer',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'BibleExperience\Http\Middleware\RedirectIfAuthenticated',
		'be.editor' => 'BibleExperience\Http\Middleware\IsBEEditor',
		'be.masterEditor' => 'BibleExperience\Http\Middleware\MasterEditor',
	];

}
