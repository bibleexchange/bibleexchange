<?php namespace BibleExperience\Providers;

use Illuminate\Support\ServiceProvider;

class SoundcloudServiceProvider extends ServiceProvider {

    public function register()
    {
		
		$this->app->singleton('Soundcloud',function(){
			
			$config = $this->app['config']['laravel-soundcloud::config'];

			return new Soundcloud( $config['client_id'], $config['client_secret'], $config['redirect_uri'] );
		});
	
    }
}