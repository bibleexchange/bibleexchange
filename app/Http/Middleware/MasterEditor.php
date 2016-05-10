<?php namespace BibleExchange\Http\Middleware;

use Closure;
use Auth;

class MasterEditor {

	public function handle($request, Closure $next){
		
		if ( Auth::check() && Auth::user()->hasRole('be_editor'))
		{
			return $next($request);
		}
		
		return response('Unauthorized.', 401);

	}

}
