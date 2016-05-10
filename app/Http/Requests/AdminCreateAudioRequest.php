<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;
use Auth;

class AdminCreateAudioRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::user()->hasRole('admin');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			"date" => "required|max:12|unique:audios",
			"title" => "required",
			"bible" => "required|reference",
			"theme" => "",
			"download" => "",
			"host" => "",
			"genre" => "string",
			"memo" => ""
		];
	}

}
