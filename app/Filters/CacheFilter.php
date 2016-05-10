<?php namespace BibleExchange\Filters;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class CacheFilter {

	public function fetch(Route $route, Request $request)
	{
		$key = $this->makeCacheKey($request->url());
		
		if(Cache::has($key)) return Cache::get($key);

	}

	public function put(Route $route, Request $request, Response $response)
	{
		
		$key = $this->makeCacheKey($request->url());
		
		if( ! Cache::has($key)) Cache::put($key,$response->getContent(),Config::get('cache.html_cache_life'));

	}
	
	public function fetchXML(Route $route, Request $request)
	{
		$key = $this->makeXMLKey($request->url());
		
		if(Cache::has($key))
		{		
			$contents = Cache::get($key);
			$response = \Response::make($contents, 200);
			$response->header('Content-Type', 'application/atom+xml; charset=UTF-8');
			return $response;
			
		}

	}
	
	public function putXML(Route $route, Request $request, Response $response)
	{
		
		$key = $this->makeXMLKey($request->url());

		if( ! Cache::has($key)) Cache::put($key,$response->getContent(),Config::get('cache.html_cache_life'));

	}
	
	protected function makeCacheKey($url)
	{
		return 'route_' . Str::slug($url);
	}
	
		protected function makeXMLKey($url)
	{
		return 'xml_' . Str::slug($url);
	}
	
}