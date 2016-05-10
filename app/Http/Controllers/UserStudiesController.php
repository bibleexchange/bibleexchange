<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests\CreateLessonRequest;
use BibleExchange\Commands\CreateLessonCommand;
use BibleExchange\Entities\Audio;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Entities\Lesson;
use BibleExchange\Entities\Course;
use BibleExchange\Entities\Page;
use BibleExchange\Entities\Study;
use BibleExchange\Entities\StudyFetcher;
use Input, Auth, Str, Flash, Redirect;
use BibleExchange\Entities\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserStudiesController extends Controller {
	
	function __construct(UserRepository $userRepository)
	{
		
		//$this->middleware('be.editor');
		$path_array = \Route::current()->parameters();
	
		$fetch = new StudyFetcher($path_array);

		$page = new Page;
		$page->make($fetch->study);

		$this->page = $page;
		$this->study = $fetch->study;
		
		$this->pathArray = $path_array;
		
		$this->userRepository = $userRepository;
		
		$this->currentUser = Auth::user();
	}
	
	public function index()
	{
		$page = $this->page;
		$study = $this->study;
		
		if(isset($_GET['q'])){
		
			$query = $_GET['q'];
		
			$studies = $this->paginateResults(Study::searchForSimilar($query, false), 4);
		}else {
		
			$studies = $this->currentUser->studies()->orderBy('updated_at', 'DESC')->paginate(8);
		
		}
		$courses = $this->currentUser->courses;

		return view('users.studies.index',compact('page','study','studies','courses'));
	}
	
	public function show($username, $lesson_slug)
	{
		$user = $this->userRepository->findByUsername($username);
	
		$lesson = $user->lessons()->published()->where('slug',$lesson_slug)->first();
		 
		$title = 'Lesson | Bible exchange';
		$meta = $this->refactorMeta($lesson->course, $lesson);
		 
		return view('users.lessons.show',compact('user','lesson','title','meta'));
	}
	
	public function hideOrShow($study)
	{
		
		$study->makePublicOrPrivate();
		$study->save();
	
		return Redirect::back();
	}
	
	public function goToStudy(){
		
		$q = Input::get('query');
		
		if($q !== ""){
			return \Redirect::to('/user/study-maker/?q=' . $q);
		}else {
			
			return \Redirect::to('/user/study-maker');
		}
	
	}
	
	protected function paginateResults(array $results, $perPage = 0)
	{
	
		$page = Input::get('page');
	
		$index = $page-1;
		if($page <= 0){
			$index = 0;
		}
	
		if(empty($results)){
			$pagedResults[0] = null;
		}else{
			$pagedResults = array_chunk($results, $perPage);
		}
	
		return new LengthAwarePaginator($pagedResults[$index], count($results), $perPage, $page,
				[
						'path'  => \Request::url()
				]);
	
	}
	
}