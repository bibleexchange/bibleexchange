<?php namespace BibleExperience\Http\Middleware;

use Closure, Redirect;
use Illuminate\Contracts\Auth\Guard;

class CreateLrs {

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

	public function handle($request, Closure $next, $guard = null)
    {
		// Checks for super admin.
		  if( ! $this->auth->user()->can('CREATE_LRS') ){
			return Redirect::to('/');
		  }

        return $next($request);
    }
	
}
