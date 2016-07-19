<?php namespace BibleExperience\Entities;

use BibleExperience\Entities\Course;
use BibleExperience\Entities\User;
use \Auth;

class Viewer extends \Eloquent {
	
	public function __construct(){
		$this->id= $this->token();
		$this->auth = $this->authenticate();		
	}
	
    private function authenticate(){
		return Auth::user();
    }
	
	private function token(){
		
		if(Auth::check()){
			return Auth::user()->token;
		}else{
			return 1;
		}
	}
	
}