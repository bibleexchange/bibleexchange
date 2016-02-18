<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Entities\Page;
use BibleExchange\Entities\Person;
use BibleExchange\Entities\Recording;
use BibleExchange\Entities\RecordingFormat;
use BibleExchange\Entities\Study;

use BibleExchange\Http\Requests\CreateBERecordingRequest;
use BibleExchange\Http\Requests\UpdateBERecordingRequest;
use BibleExchange\Http\Requests\UploadMarkdownRequest;

use BibleExchange\Commands\CreateBERecordingCommand;
use BibleExchange\Commands\UpdateBERecordingCommand;
//$date, $dated, $description, $genre, $title
use BibleExchange\Helpers\Helpers as Helper;
use Illuminate\Http\Request;
use Auth, View, Input, Flash, Redirect, Session; 
use Illuminate\Pagination\LengthAwarePaginator;

class RecordingsController extends Controller {
	
	function __construct(){
	
		$this->middleware('be.masterEditor', ['except' => ['index','show','goToRecording']]);
		
		$path_array = \Route::current()->parameters();
		
		if ( array_key_exists('recording',$path_array)){
			
			$exploded = explode('-',$path_array['recording'],2);
			
			$recording = Recording::find($exploded[0]);
		} 
		
		if (! isset($recording) || $recording === null){
			$recording = new Recording;
		}
		
		$page = new Page;
		$page->make($recording);

		$this->page = $page;
		$this->recording = $recording;
		$this->pathArray = $path_array;
		
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$page = $this->page;
		$recording = $this->recording;
		$recordings = recording::soundcloud()->orderBy('dated', 'DESC')->paginate(12);
		$session_last_feature = false;
		$session_last_course = null;
		
		if (Session::get('last_edited_study_id'))
		{
			$session_last_course = Study::find(Session::get('last_edited_study_id'));
			$session_last_feature = true;
		}
		
		return view('recordings.index',compact('page','recording','recordings','session_last_feature','session_last_course'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateBERecordingRequest $request)
	{
		$input = Input::all();
		
		$recording = $this->dispatch(new CreateBERecordingCommand($input));
		 
		Flash::success('This recording has begun!');
		
		return Redirect::to($recording->url());
		
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
		$recording = $this->recording;
		$session_last_feature = false;
		$session_last_course = null;
		
		if (Session::get('last_edited_study_id'))
		{
			$session_last_course = Study::find(Session::get('last_edited_study_id'));
			$session_last_feature = true;
		}
		
		if ($recording->exists){
			$page->title = $recording->present()->title;
			return view('recordings.show',compact('page','recording','session_last_feature','session_last_course'));
		}
		
		$similarRecordings = Recording::searchForSimilar($this->pathArray['recording']);

		$similarRecordings = $this->paginateResults($similarRecordings, 12);
		
		\Flash::warning('I can\'t find that recording.');
		
		return view('recordings.search',compact('page','recording','similarRecordings','session_last_feature','session_last_course'));
		
	}
	
	public function create()
	{
		$page = $this->page;
		$recording = $this->recording;
		$creating = true;
		
		if(Input::old('title') !== null){
			$oldinput = Input::old();
		}else{
			$oldinput = null;
		}
		
		if(\Session::has('recording_file_uploaded')){
			$file_uploaded = \Session::get('recording_file_uploaded');
		}else{
			$file_uploaded = null;
		}
		
		$form = $this->makeEditForm($recording, $oldinput, $file_uploaded);
		
		return view('recordings.create',compact('page','recording','creating','form'));
	}
	
	public function goToRecording($query = null){
		
		
		if( isset($_POST['query']))
		{
			$query = $_POST['query'];
		}
		
		return \Redirect::to('/r/'.Helper::userTitletoUrl($query));
	
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		
		$page = $this->page;
		$recording = $this->recording;
		Session::put('last_edited_recording_id',$recording->id);
		$persons = Person::orderBy('lastname','ASC')->get()->lists('fullname','id');
		
		$recording_tags_string = Helper::arrayToCommaString($recording->tags);
		
		
		if(Input::old('title') !== null){
			$oldinput = Input::old();
		}else{
			$oldinput = null;
		}
		
		if(\Session::has('recording_file_uploaded')){
			$file_uploaded = \Session::get('recording_file_uploaded');
		}else{
			$file_uploaded = null;
		}
		
		$form = $this->makeEditForm($recording, $oldinput, $file_uploaded);

		return view('recordings.edit',compact('page','recording','form','persons','recording_tags_string'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UpdateBERecordingRequest $request)
	{

		$recording = $this->recording;
		$input = Input::all();
		
		$recording = $this->dispatch(new UpdateBERecordingCommand($recording, $input));

		Flash::success('Your changes were saved!');
		
		return \Redirect::back();
	}
	
	public function updateTitle(){
	
		$recording = $this->recording;
		$recording->title= Helper::userTitleToUrl(Input::get('title'));
	
		if($recording->title !== null){
			$recording->save();
			Flash::success('Your changes were saved!');
			return Redirect::to($recording->url());
		} else {
			Flash::error('your change could not be saved!');
			return Redirect::back();
		}
	
		
	}
	
	public function updateMainVerse(){
		
		$recording = $this->recording;
		$recording->main_verse = BibleVerse::referenceTranslator(Input::get('main_verse'))[0];
		
		if($recording->main_verse !== null){
			$recording->save();
			Flash::success('Your changes were saved!');
		} else {
			Flash::error('not a valid Scripture reference!');
		}
		
		return Redirect::back();
	}
	
	public function updateDescription(){
	
		$recording = $this->recording;
		$recording->description = Input::get('description');
	
		if($recording->description !== null){
			$recording->save();
			Flash::success('Your changes were saved!');
		} else {
			Flash::error('Your changes couldn\'t be saved!');
		}
	
		return Redirect::back();
	}
	
	public function addToStudy(){
		
		//!!
		//Create validation for request soon
		//!!
		
  		$study = Study::find(Input::get('study_id'));
	    
  		$study->recordings()->attach(Input::get('recording_id'));
  		
	    Flash::success('Uploaded successfully');
		
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
	
	public function makeEditForm($recording, $oldinput = false, $file_uploaded = false){
		
		$form = new \stdClass();
		$form->dated = $recording->dated;
		$form->date = $recording->date;
		$form->title = $recording->title;
		$form->description = $recording->description;
		$form->genre = $recording->genre;
		
		if($oldinput !== null){
		
			$form->dated = Input::old('dated');
			$form->date = Input::old('date');
			$form->title = Input::old('title');
			$form->description = Input::old('description');
			$form->genre = Input::old('genre');
		
		}else if ($file_uploaded !== null){
		
			$file_array = explode('=@',$file_uploaded);
		
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
				$form->description = $file_uploaded;
			}
		
		}
		
		return $form;
	}
	
	public function createFormat(){
		
		$format = RecordingFormat::make(Input::get("recording_id"), Input::get("file"), Input::get("format"), Input::get("memo"));
		
		Flash::success('Success!');
		
		return Redirect::to($format->recording->editUrl());
		
	}
	
	public function destroyFormat(){
		
		$format = RecordingFormat::find(Input::get('format_id'));

		if($format->exists){
			$format->delete();
	
			Flash::success('Successfully deleted!');
		}else{
			Flash::error('Could not delete that. Something went wrong.');
		}
		
		return Redirect::back();
	
	}
	
	public function addScripture(){
		
		$recording = Recording::find(Input::get('recording_id'));
		$scriptures = BibleVerse::referenceTranslator(Input::get('reference'));
		
		if($scriptures !== null && is_array($scriptures)){
			
			$recording->verses()->sync($scriptures);
			
			Flash::success('Your changes were saved!');
		} else {
			Flash::error('not a valid Scripture reference!');
		}
	
		return Redirect::back();
	}
	
	public function detachVerse(){

		$recording = Recording::find(Input::get('recording_id'));
		$recording->verses()->detach(Input::get('verse_id'));
				
		Flash::success('Your changes were saved!');

		return Redirect::back();
	}
	
	public function attachPerson(){
	
		$recording = Recording::find(Input::get('recording_id'));
		$recording->persons()->attach(Input::get('person_id'),['role'=>Input::get('role'),'memo'=>Input::get('memo')]);
	
		Flash::success('Your changes were saved!');
	
		return Redirect::back();
	}
	
	public function detachPerson(){
	
		$recording = Recording::find(Input::get('recording_id'));
		$recording->persons()->detach(Input::get('person_id'));
	
		Flash::success('Your changes were saved!');
	
		return Redirect::back();
	}
	
	public function delete(){
		dd(Input::all());
		
		$recording = Recording::find(Input::get('recording_id'));
		$recording->delete();
	}
	
}
