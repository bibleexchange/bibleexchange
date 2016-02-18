<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;
use Auth;

class CreateLessonRequest extends Request {

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
			'title' => 'required|min:3'
		];
	}

}
