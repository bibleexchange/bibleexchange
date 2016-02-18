<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;
use Auth;

class CreateBERecordingRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if(Auth::user() !== null && Auth::user()->hasRole('be_editor')){ return true; }
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		
		return [
			'title' => 'required|min:3',
			'dated' => 'required|date',
			'genre' => 'required'
		];
	}

}
