<?php namespace BibleExperience\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class SetApiHeaders {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		/////BROKEN
		$response->headers->set('X-Experience-API-Version', '1.0.1');

		if (isset($_SERVER['HTTP_ORIGIN'])) {
			$response->headers->set('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
		}


		return $next($request);
	}

}
