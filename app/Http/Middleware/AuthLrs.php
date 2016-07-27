<?php namespace BibleExperience\Http\Middleware;

use Closure, Redirect;
use Illuminate\Contracts\Auth\Guard;

class AuthLrs {

	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	public function handle($request, Closure $next, $guard = null)
    {
		// Checks for super admin.
		  if( ! $this->auth->user()->can('VIEW_DASHBOARD') ){
			return Redirect::to('/');
		  }

        return $next($request);
    }
	
}
