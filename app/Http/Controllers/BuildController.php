<?php namespace BibleExperience\Http\Controllers;

use BibleExperience\Http\Requests;
use BibleExperience\Http\Controllers\Controller;
use BibleExperience\Build\Course;
use BibleExperience\BibleVerse;
use Illuminate\Http\Request;
use Auth, Input, Redirect;

use BibleExperience\Course AS BCourse;

class BuildController extends Controller {

	function __construct(){
		$this->courseDir = resource_path() . '/courses';
		//$this->middleware('auth');
		//$this->currentUser = Auth::user();
	}

	public function index()
	{
		$courseFiles =  array_diff( scandir($this->courseDir), array(".", "..") );
		$data = [];

		foreach($courseFiles AS $course){
			$data[] = $this->getContent($course);
		}

		$courses = $data;

	foreach(BCourse::all() AS $c){
		var_dump($c->id, $c->title, '<br/>');
	}
die;
		return view('build.index',compact('courses'));

	}

	public function publish($course)
	{
		$course = BCourse::find($course);
		$cb = new Course("");
		return view('build.show',compact('course','cb'));
	}

	public function getContent($course)
	{
		$content = file_get_contents($this->courseDir."/".$course);
		return json_decode($content);
	}

	public function quiz()
	{
		$q = '';

		$quiz = new Quiz(json_decode($q));

		return view('build.show-quiz',compact('quiz'));
	}

}
