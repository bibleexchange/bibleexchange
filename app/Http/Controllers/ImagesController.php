<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use Config, File, Response;
use Illuminate\Http\Request;
use BibleExchange\Entities\Course;
use BibleExchange\Entities\Image;
use BibleExchange\Entities\Study;
use Flash, Input, Redirect, Session;

class ImagesController extends Controller {
	
	function __construct(\BibleExchange\Presenters\ImagePresenter $imagePresenter){
		
		$this->middleware('be.masterEditor', ['except' => ['index','show','wiki']]);
		
		$this->imagePresenter = $imagePresenter;
		
	}
	
	public function index()
	{
		
		$images = Image::paginate(10);
		$session_last_feature = false;
		$last_edited_study = null;
		$last_edited_course = null;
		
		if (Session::get('last_edited_study_id'))
		{
			$session_last_feature = true;
			$last_edited_study = Study::find(Session::get('last_edited_study_id'));
		}
		
		if (Session::get('last_edited_course_id'))
		{
			$session_last_feature = true;
			$last_edited_course = Course::find(Session::get('last_edited_course_id'));
		}
		
		return view('photos.index',compact('images','session_last_feature','last_edited_study','last_edited_course'));
	
	}
	
	
	public function show($src1, $src2 = null, $src3 = null, $src4 = null)
	{

		$file = $src1.'/'.$src2.'/'.$src3.'/'.$src4;
		
		$image = $this->imagePresenter->outputImage($file, $_GET);
		
		return $image;

	}
	
	public function wiki($src1, $src2 = null, $src3 = null, $src4 = null, $src5 = null)
	{
		
		$file = $src1."/".$src2."/".$src3."/".$src4."/".$src5;
		
		$image = $this->imagePresenter->wikiImage($file, $_GET);
	
		return $image;
	
	}
	
	public function copyImageToSession(){
		
		if(Input::has('study_id')){
			$study = Study::find(Input::get('study_id'));
			$study->image_id = Input::get('image_id');
			$study->save();
			Flash::success('Image updated.');
			return Redirect::to($study->editUrl());
			
		}else if(Input::has('course_id')){
			$course = Course::find(Input::get('course_id'));
			$course->image_id = Input::get('image_id');
			$course->save();
			Flash::success('Image updated.');
			return Redirect::to($course->editUrl());
		}
		
			Flash::error('Something went wrong!');
			
			return Redirect::back();
		
	}
	
}