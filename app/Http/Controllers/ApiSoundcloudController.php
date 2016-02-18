<?php namespace BibleExchange\Http\Controllers;

class SoundcloudController extends ApiController {
	
	public function __construct(Soundcloud $soundcloud){
		
		$this->sound = $soundcloud;
		
	}

	  public function getIndex()
    {		
		$authURL = $this->sound->getAuthorizeURL();
		dd($authURL);
		
    }
	
	  public function getMethod($method,$action)
    {		
		return $this->$method($action);
    }
	
	public function soundcloud($action)
	{
		
	}
	
	public function getSoundcloudCallBack(){
		
	}
}