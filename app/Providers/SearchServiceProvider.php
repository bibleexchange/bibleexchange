<?php namespace BibleExchange\Providers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->singleton('search','BibleExchange\Services\Search');
	}


}