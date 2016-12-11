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

    protected $middlewareGroups = [
        'web' => [
            \BibleExperience\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \BibleExperience\Http\Middleware\VerifyCsrfToken::class
        ],
        'api' => [
            'throttle:60,1',
        ]
    ];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => \BibleExperience\Http\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'auth.simple' => \BibleExperience\Http\Middleware\AuthSimple::class,
		'auth.viewer' => \BibleExperience\Http\Middleware\AuthenticateViewer::class,
		'guest' => \BibleExperience\Http\Middleware\RedirectIfAuthenticated::class,
		'registration.status' => \BibleExperience\Http\Middleware\RegistrationStatus::class,
		'auth.statement' => \BibleExperience\Http\Middleware\AuthStatement::class,
		'auth.super' => \BibleExperience\Http\Middleware\AuthSuper::class,
		'auth.lrs' => \BibleExperience\Http\Middleware\AuthLrs::class,
		'edit.lrs' => \BibleExperience\Http\Middleware\EditLrs::class,
		'create.lrs' => \BibleExperience\Http\Middleware\CreateLrs::class,
        	'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
                'auth0.jwt' => '\Auth0\Login\Middleware\Auth0JWTMiddleware',
		'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
		'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class
	];

}
