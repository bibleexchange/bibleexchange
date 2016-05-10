<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use BibleExchange\Entities\Answer;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Entities\Image;
use BibleExchange\Entities\Page;
use BibleExchange\Entities\Question;
use BibleExchange\Entities\Study;
use BibleExchange\Entities\StudyFetcher;

use Auth, View, Input, Flash, Redirect, Session, stdClass;
use Illuminate\Http\Request;

class TestsController extends Controller {

	function __construct(){
	
		$this->middleware('be.editor', ['except' => ['index']]);
		$path_array = \Route::current()->parameters();
	
		$fetch = new StudyFetcher($path_array);
	
		$page = new Page;
		$page->make($fetch->study);
	
		$this->page = $page;
		$this->study = $fetch->study;
	
		$this->pathArray = $path_array;
	
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($study)
	{
		$user = Auth::user();
		$question = Question::find(Input::get('question_id'));
		
		if ($question->answered($user->id) === null)
		{
		$answer = Answer::create([
					'answer'=>Input::get('answer'),
					'user_id'=>$user->id,
					'study_id'=>$study->id,
					'question_id'=>$question->id
				]);
		}else{
			
			$answer = $question->answered($user->id);
			
			$answer->update([
					'answer'=>Input::get('answer'),
					'user_id'=>$user->id,
					'study_id'=>$study->id,
					'question_id'=>$question->id,
					'attempts'=>$answer->attempts+1
			]);
			
		}
		
		$answer->gradeIt()->save();
		
		return Redirect::back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($study)
	{
		
		$page = $this->page;
		
		if ($study->exists){
			
			$progress = $study->testProgress(Auth::user());
			
			return view('studies.test',compact('study','page','progress'));
		}
		
		return App::abort();
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
