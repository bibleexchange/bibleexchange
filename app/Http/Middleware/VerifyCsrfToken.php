<?php namespace BibleExperience\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

	protected $except = [
	  'graphql*',
	  'api*',
	  'oauth*',
	  'graph*'
	];

	public function handle($request, Closure $next)
	{
		if ( ! $request->is('graphql*'))
		{
			return parent::handle($request, $next);
		}

		return $next($request);
	}

}
