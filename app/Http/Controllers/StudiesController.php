<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use BibleExchange\Entities\BibleBook;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Entities\BibleHighlight;
use BibleExchange\Entities\Course;
use BibleExchange\Entities\Image;
use BibleExchange\Entities\Page;

use BibleExchange\Entities\Study;
use BibleExchange\Entities\StudyFetcher;

use BibleExchange\Entities\Task;
use BibleExchange\Entities\TaskProperty;
use BibleExchange\Entities\TaskType;
use BibleExchange\Entities\UserRepository;
use BibleExchange\Http\Requests\CreateBEStudyRequest;
use BibleExchange\Http\Requests\UpdateBEStudyRequest;
use BibleExchange\Http\Requests\UploadMarkdownRequest;
use BibleExchange\Commands\CreateBEStudyCommand;
use BibleExchange\Commands\UpdateBEStudyCommand;
use BibleExchange\Helpers\Helpers as Helper;
use Illuminate\Http\Request;
use Auth, View, Input, Flash, Markdown, Redirect, Session, stdClass; 
use Illuminate\Pagination\LengthAwarePaginator;

class StudiesController extends Controller {
	
	function __construct(UserRepository $userRepository){
		
		$this->middleware('be.editor', ['except' => ['index','show','studySpace','showTag','goToStudy','userIndex','create','store','uploadTextFile']]);
		$this->middleware('auth', ['only' => ['create','store','uploadTextFile']]);
		
		$path_array = \Route::current()->parameters();
		
		$fetch = new StudyFetcher($path_array);

		$page = new Page;
		$page->make($fetch->study);

		$this->page = $page;
		$this->study = $fetch->study;
		
		$this->pathArray = $path_array;
		$this->userRepository = $userRepository;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$page = $this->page;
		$study = $this->study;
		$studies = Study::orderBy('updated_at', 'DESC')->public()->paginate(9);
		$courses = Course::where('public','1')->get();
		
		return view('studies.index',compact('page','study','studies','courses'));
	}
	
	public function userIndex($username)
	{
		$user = $this->userRepository->findByUsername($username);

		$studies = $user->studies()->public()->paginate(9);

		return view('users.studies.index-public',compact('studies','user'));
	}
	
	public function create()
	{
	
		$page = $this->page;
		$study = $this->study;
		$creating = true;
	
		$form = new \stdClass();
		$form->title = $study->title;
		$form->body = null;
		$form->comment = null;
		$form->description = null;
	
		if(Input::old('text') !== null){
				
			$form->body = Input::old('text');
			$form->title = Input::old('title');
			$form->comment = Input::old('comment');
			$form->description = Input::old('description');
				
		}else if (\Session::has('body')){
				
			$file_array = explode('=@',\Session::get('body'));
				
			if(count($file_array) >= 2){
	
				foreach($file_array AS $b){
					$temp = explode(':', $b,2);
						
					if(isset($temp[1])){
						$index = $temp[0];
						$content = $temp[1];
						$form->$index = $content;
					}
						
				}
	
			}else{
				$form->body = \Session::get('body');
			}
				
		}
	
		return view('studies.create',compact('page','study','creating','form'));
	
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateBEStudyRequest $request)
	{

		$description = Input::get('description');
		$title = Input::get('title');
		$text = Input::get('text');
		$comment = Input::get('comment');
		$minor_edit = Input::get('minor_edit');
		
		$study = $this->dispatch(new CreateBEStudyCommand($description,$title,Auth::user()->id, $text, $comment, $minor_edit));
		 
		Flash::success('This study has begun!');
		
		return Redirect::to($study->editUrl());
		
	}
	
	public function uploadTextFile(UploadMarkdownRequest $request)
	{
		
	  	$file = Input::file('file');
	  
	  	if ($file->isValid()){
	  		
	  		$destinationPath = public_path().'/uploads'; // upload path
		    $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
		    $fileName = rand(11111,99999).'.'.$extension; // renameing image
		    
		    $file->move($destinationPath, $fileName); // uploading file to given path
		     
		    Flash::success('Uploaded successfully'); 
		    
		    return Redirect::back()->with('body',file_get_contents(public_path().'/uploads/'.$fileName));
	  	}
	  	
	  	Flash::error('File couldn\'t be uploaded');
	  	
	  	return Redirect::back();

	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		
		$page = $this->page;
		$study = $this->study;

		if ($study->exists && $study->isPublic()){
			
			$page->title = $study->present()->title;
			$article = $study->published_html;
			
			return view('studies.show',compact('article','page','study'));
		}
		
		$similarStudies = Study::searchForSimilar($this->pathArray['studythis']);
		
		if(empty($similarStudies)){
			
			Flash::message('No public studies match your request.');
		}
		
		$similarStudies = $this->paginateResults($similarStudies, 6);
		
		return view('studies.does-not-exist',compact('page','study','similarStudies'));
		
	}
	
	public function studySpace($study,$titleSlug)
	{
		
		$bible = false;
		$booksOftheBible = [];
		
		
		if($study->mainVerse !== null){
			$currentReference = $study->mainVerse->reference;
		}else if(Session::has('last_scripture')){
		
			$currentReference = Session::get('last_scripture_readable');
				
		}else{
			
			$currentReference = 'John 1';
			
		}

		if($currentReference !== null){
			
			$chapter = BibleVerse::isValidReference($currentReference)->chapter;
			
			$booksOftheBible = BibleBook::all();
			$recent_chapters = [null];
			
			if($chapter !== false){
				$bible = true;
				$currentReference = $chapter->reference;

			}
			
		}
		
		$page = $this->page;
		$study = $this->study;
		
		$highlight_colors = BibleHighlight::getColors();
		
		if ($study->exists && $study->isPublic()){
			
			$page->title = $study->present()->title;
			$article = $study->published_html;

		}else{
			
			$study = new Study;
			
			Flash::message('I could not find that study!');
		}

		$data_path = '/api/v1/views/bible/chapter/';
		$data_path_search = '/api/v1/bible/search/';
		
		return view('studies.show',compact('article','data_path','data_path_search','page','study', 'bible','chapter','highlight_colors','currentReference','booksOftheBible','recent_chapters'));
		
	}
	
	public function showTag($tag)
	{
		
		$page = $this->page;
		
		
		$study = $this->study;
		
		$similarStudies = Study::whereHas('tags', function($q) use ($tag)
							{
							    $q->where('name', 'like', $tag.'%');
							
							})->paginate(6);
	
		if(empty($similarStudies)){
				
			Flash::message('No public studies match your request.');
		}
		
		$page->title = '(' . $similarStudies->total() . ') Studies Tagged "'. $page->title .'"';
		
		return view('studies.tagged',compact('page','study','similarStudies', 'tag'));
	
	}
	
	public function preview()
	{
	
		$page = $this->page;
		$study = $this->study;
	
		if ($study->exists){
			$page->title = '[PREVIEW] '.$study->present()->title;
			
			$article = nl2br(Markdown::convertToHtml($study->text()->text));
			
			return view('studies.preview',compact('article','page','study'));
		}
	}
	
	public function goToStudy(){
	
		$query = $_POST['query'];
		
		if($query !== ""){
		
			return \Redirect::to(Helper::userTitletoUrl($query));
		} else {
			
			return \Redirect::to('/study');
		}
	
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($study)
	{
		
		$page = $this->page;
		$study = $this->study;
		Session::put('last_edited_study_id',$study->id);
		$study_tags_string = Helper::arrayToCommaString($study->tags);
		
		$task_types = TaskType::where('name','test')->get()->lists('name','id');
		
		$form = new \stdClass();
		$form->title = $page->title;
		
		if($study->text() === null){
			$form->body = null;
		} else {
			$form->body = $study->text()->text;
		}
		$form->comment = $study->comment;
		$form->description = $study->description;
		
		if(Input::old('text') !== null){
				
			$form->body = Input::old('text');
			$form->comment = Input::old('comment');
			$form->description = Input::old('description');
				
		}else if (\Session::has('body')){
				
			$file_array = explode('=@',\Session::get('body'));
				
			if(count($file_array) >= 2){
				
				$exclude_these = ['description','title'];
				
				foreach($file_array AS $b){
					$temp = explode(':', $b,2);
						
					if(isset($temp[1]) && ! in_array($temp[0],$exclude_these)){
						$index = $temp[0];
						$content = $temp[1];
						$form->$index = $content;
					}
						
				}
		
			}else{
				$form->body = \Session::get('body');
			}
				
		}

		return view('studies.edit',compact('page','study','form','study_tags_string','task_types'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateBEStudyRequest $request)
	{

		$study = $this->study;
		
		$text = Input::get('text');

		if(Input::get('translate_verses') >= 1){
			$text = Helper::convertReferences($text);
		}
		
		$comment = Input::get('comment');
		$minor_edit = Input::get('minor_edit');
		
		$study = $this->dispatch(new UpdateBEStudyCommand($study, Auth::user()->id, $text, $comment, $minor_edit));

		Flash::success('Your changes were saved!');
		
		return \Redirect::back();
	}
	
	public function updateTitle(){
	
		$study = $this->study;
		$study->title= Helper::userTitleToUrl(Input::get('title'));
	
		if($study->title !== null){
			$study->save();
			Flash::success('Your changes were saved!');
			return Redirect::to($study->url());
		} else {
			Flash::error('your change could not be saved!');
			return Redirect::back();
		}
	
		
	}
	
	public function updateMainVerse(){
		
		$study = $this->study;
		$study->main_verse = BibleVerse::referenceTranslator(Input::get('main_verse'))[0];
		
		if($study->main_verse !== null){
			$study->save();
			Flash::success('Your changes were saved!');
		} else {
			Flash::error('not a valid Scripture reference!');
		}
		
		return Redirect::back();
	}
	
	public function updateDescription(){
	
		$study = $this->study;
		$study->description = Input::get('description');
	
		if($study->description !== null){
			$study->save();
			Flash::success('Your changes were saved!');
		} else {
			Flash::error('Your changes couldn\'t be saved!');
		}
	
		return Redirect::back();
	}
	
	public function updateStudyIcon(){
		
		$file = Input::file('file');
	  	
	  	if ($file->isValid()){
	  		
	  		//Get the Context of the Image
	  		$study = Study::find($this->study->id);
	  		
	  		//Get Unique String
	  		$uuid = str_replace([' ','.'],'',microtime());
	  		
	  		//Place Image
	  		$destinationPath = public_path().'/images/uploads'; // upload path
		    $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
		    $fileName = $uuid.'.'.$extension; // renameing image
		    $file->move($destinationPath, $fileName); // uploading file to given path
		    
		    //Enter Image into Database
		    $dbImage = new Image;
		    $dbImage->name = $uuid.'.'.$extension;
		    $dbImage->src = url('/images/uploads/'.$fileName);
		    $dbImage->alt_text = $study->present()->title;
	 		$dbImage->bible_verse_id = $this->study->mainVerse->id;
	 		$dbImage->user_id = Auth::user()->id;
		    $dbImage->save();
		    
		    //Set Image as Default Image for Study
		    $study->image_id = $dbImage->id;
		    $study->save();
		    
		    //Notify User of Success
		    Flash::success('Uploaded successfully');
			
		    return Redirect::back();
	  	}
		
	  	Flash::error('File couldn\'t be uploaded');
	  	
	  	return Redirect::back();
	  	
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
	
	public function detachRecording(){
		
		//!!
		//Create Validation for request
		//!!
		
		$study = Study::find(Input::get('study_id'));
		$study->recordings()->detach(Input::get('recording_id'));
		
		Flash::success('Successfuly removed recording with #'.Input::get('recording_id'));
		
		return Redirect::back();
	}

	public function publish($study)
	{

		$study->publish();
		$study->save();
	
		return Redirect::back();
	}
	
	public function storeTask($study){
	
		$type = Input::get('task_type');
	
		$orderBy = $study->tasks->count() + 1;
	
		$count = $study->tasks()->where('task_type_id',$type)->count() + 1;
		
		$task = $study->tasks()->create([
				'task_type_id'=> $type,
				'orderBy'=> $orderBy,
				'title'=> '#' . $count
		]);
	
		Flash::success('Task Created.');

		return Redirect::to('/user/study-maker/256/task/'.$task->id.'/edit');
	}
	
	public function editTask($study, $task){
	
		$task = $task->buildEditor();
		
		$page = new stdClass();
		$page->title = 'Builder';

		return view($task->templates->edit, compact('study','task','page'));
	
	}
	
	public function updateTask($study, $task)
	{
	
		$task->update([
				'title'=> Input::get('title'),
				'instructions'=> Input::get('instructions'),
				'points'=>Input::get('points')
		]);
	
		Flash::success('Your changes were saved.');
	
		return Redirect::back();
	}
	
	public function attachTaskProperty(){
	
		TaskProperty::taskThis(
		Input::get('task'),
		Input::get('object_class'),
		Input::get('object_id')
		);
	
		Flash::success('New property successfuly added.');
	
		return Redirect::back();
	}
	
}
