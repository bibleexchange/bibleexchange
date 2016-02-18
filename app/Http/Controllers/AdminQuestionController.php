<?php namespace BibleExchange\Http\Controllers;

class AdminQuestionController extends \ResourceController {
	 
	 public function __construct() {
	 
		$this->Resource = new Question();	 
	
		View::share('Resource',$this->Resource);		
		
		$Contacts = Contact::orderBy('lastname','ASC')->get();
		View::share('Contacts',$Contacts->lists('full_name','id'));
		
		$Questions = new Question();
		View::share('Chapters',$Questions->allByCourse(isset($_GET['course']) ? $_GET['course'] : "all"));
		
	 }
	 
}