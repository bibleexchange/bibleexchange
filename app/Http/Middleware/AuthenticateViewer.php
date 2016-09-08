<?php namespace BibleExperience\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateViewer {

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
		
		if ($this->auth->guest())
		{
			return response()->json(["message"=>"you are not signed in silly!"], 401);
		}
		
		return $next($request);
	}

}
