<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;
use Auth;

class CreateCourseRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if(Auth::user() !== null){ return true; }
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'course_title' => 'required|min:3|unique:courses,title',
			'course_subtitle' => 'required|min:3',
			'course_shortname' => 'required|min:3|max:12|unique:courses,shortname'			
		];
	}

}
