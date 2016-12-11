<?php namespace BibleExperience\Presenters;

class ImagePresenter {

    public function __construct(){
        	
		$this->server = \League\Glide\ServerFactory::create([
					
				'source'=> base_path().'/resources/images',
				'cache'=> storage_path().'/framework/cache/images'
		]);
		
		$this->server2 = \League\Glide\ServerFactory::create([
				 
				'source'=> base_path().'/Wiki/resources/',
				'cache'=> storage_path().'/framework/cache/images'
		]);
		
    }
   
    public function outputImage($file, $instructions = null){
    	
    	$image = $this->server->outputImage($file, $instructions);
    	
    	return $image;
    	
    }
    
    public function wikiImage($file, $instructions = null){
    	 
    	$image = $this->server2->outputImage($file, $instructions);
    	 
    	return $image;
    	 
    }
    
}

