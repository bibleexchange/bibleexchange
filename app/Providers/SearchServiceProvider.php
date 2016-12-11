<?php namespace BibleExperience\Providers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->singleton('search','BibleExperience\Services\Search');
	}


}