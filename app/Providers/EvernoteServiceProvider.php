<?php namespace BibleExperience\Providers;

use Illuminate\Support\ServiceProvider;

class EvernoteServiceProvider extends ServiceProvider {

    public function register()
    {
		
		$this->app->singleton('Evernote',function(){			
			return new BibleExperience\Helpers\Evernote;
		});
	
    }
}