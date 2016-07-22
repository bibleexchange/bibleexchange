<?php namespace BibleExperience\Http\Middleware;

use Closure;

class RegistrationStatus {

	public function handle($request, Closure $next)
	{
		
		/*
		|---------------------------------------------------------------------------
		| Check whether registration has been enabled
		|---------------------------------------------------------------------------
		*/

		$site = \BibleExperience\Site::first();

		  if( $site !== null){
			if( $site->registration != 'Open' ) return \Redirect::to('/');
		  }

		return $next($request);
	}

}
