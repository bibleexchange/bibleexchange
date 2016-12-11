<?php namespace BibleExperience\Http\Requests;

use BibleExperience\Http\Requests\Request;
use Auth;

class UpdateBEStudyRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if(Auth::check()){ return true; }
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
