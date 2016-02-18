<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use BibleExchange\Http\Requests\UpdateCourseImageRequest;
use BibleExchange\Entities\Course;
use BibleExchange\Entities\Image;
use BibleExchange\Entities\Section;
use BibleExchange\Entities\Task;
use BibleExchange\Entities\TaskProperty;
use BibleExchange\Entities\TaskType;

use Illuminate\Http\Request;
use Auth, Flash, Input, Redirect, Session, stdClass, Str;

class CourseMakerController extends Controller {
	
	function __construct(){
		$this->middleware('auth');
		$this->currentUser = Auth::user();
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$userCourses = $this->currentUser->courses()->orderBy('updated_at','DESC')->paginate(12);
		$page = new stdClass();
		$page->title = 'Course Maker ('.$userCourses->total().')';
		
		$form = new stdClass();
		$form->title = '';
		$form->description = '';
		
		return view('course-maker.index',compact('userCourses','page','form'));
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
	public function store()
	{
		$title = Input::get('title');
		$description = Input::get('description');
		
		$uuid = Str::random(10);
		
		if (Course::where('uuid')->get()->count() > 0){
			$uuid = Str::random(10);
		}
		
		$course = new Course;
		$course->uuid = $uuid;
		$course->title = $title;
		$course->description = $description;
		$course->user_id = $this->currentUser->id;
		$course->save();
		
		Flash::success('You can now build your course.');
		
		return Redirect::to($course->editUrl());
	}
	
	public function storeSection($course){

		$title = Input::get('title');
		$description = Input::get('description');
	
		$orderBy = $course->sections->count() + 1;
		
		$course->sections()->create([
				'title'=> $title,
				'description'=> $description,
				'orderBy'=> $orderBy
		]);
		
		Flash::success('Section Created.');
	
		return Redirect::to($course->editUrl());
	}
	

	
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($course)
	{
		
		if( ! $course){
			
			Flash::error('Course doesn\'t exist.');
			
			return Redirect::to('/user/course-maker');
		}
		
		
		Session::put('last_edited_course_id',$course->id);
		
		$page = new stdClass();
		$page->title = 'Editing Course: "'.$course->title.'"';
		
		$form = new stdClass();
		$form->title = $course->title;
		$form->description = $course->description;
		$form->existing_image_id = null;
		
		$task_types = TaskType::get()->lists('name','id');
		
		return view('course-maker.edit', compact('course','form','page','task_types'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($course)
	{

		$course->update([
			'title'=> Input::get('title'),
			'description'=> Input::get('description'),
		]);
		
		Flash::success('Your changes were saved.');
		
		return Redirect::back();
	}
	
	public function updateImage(UpdateCourseImageRequest $request, $uuid){
		
		$course = Course::where('uuid',$uuid)->first();

		$image_id = Image::upload(Input::file('file'), $course, $this->currentUser);

		$course->image_id = $image_id;
		$course->save();
		
		Flash::success('Image updated.');
		
		return Redirect::to($course->editUrl());
	}
	
	public function updateSection($course, $section)
	{
	
		$section = Section::find($section_id)->update([
				'title'=> Input::get('title'),
				'description'=> Input::get('description'),
		]);
	
		Flash::success('Your changes were saved.');
	
		return Redirect::back();
	}
	
	public function attachStudy($course, $section)
	{
		
		$orderBy = $section->studies->count() + 1;
		
		$section->studies()->attach(Input::get('study'),['orderBy' => $orderBy]);
	
		Flash::success('Study was added to Section.');
	
		return Redirect::back();
	}
	
	public function publish($course)
	{
	
		$course->publish();
		$course->save();
	
		return Redirect::back();
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
