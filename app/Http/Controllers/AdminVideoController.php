<?php namespace BibleExchange\Http\Controllers;

class AdminVideoController extends \ResourceController {
	 
	public function __construct() {
	 
	 $this->Resource = new Video();	 
	
     View::share('Resource',$this->Resource);
	 
	 }
	 
}
