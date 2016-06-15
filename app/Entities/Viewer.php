<?php namespace BibleExchange\Entities;

use BibleExchange\Entities\Course;
use BibleExchange\Entities\User;
use \Auth;

class Viewer extends \Eloquent {
	
	public function __construct($courseId){
		$this->id= $this->token();
		$this->auth = $this->authenticate();
		$this->courses = $this->courses();
		$this->courseId = $courseId;
		$this->course = $this->course();
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
	
	public function courses(){
		return new Course();
	}

	public function course(){
		return Course::find(1);
	}

}