<?php namespace BibleExperience\Http\Requests;

use BibleExperience\Http\Requests\Request;

class UpdateCourseImageRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{		
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [

		];
	}

}
