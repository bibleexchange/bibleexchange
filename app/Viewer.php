<?php namespace BibleExperience;

use BibleExperience\Course;
use BibleExperience\User;
use \Auth;

class Viewer extends \Eloquent {
	
	public function __construct($options){
		$this->id = $this->token();
		$this->auth = $this->authenticate();
		$this->bible = \BibleExperience\Bible::find(1);
		$this->bibleChapter = \BibleExperience\BibleChapter::find($options['bibleChapter']);
	}
	
    private function authenticate(){
		return Auth::user();
    }
	
	private function token(){

		if(Auth::check()){
			return Auth::user()->token;
		}else{
			return null;
		}
	}
	
}