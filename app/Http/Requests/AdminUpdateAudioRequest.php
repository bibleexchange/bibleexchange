<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;
use Auth;

class AdminUpdateAudioRequest extends Request {

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
			"date" => "max:12",
			"title" => "",
			"bible" => "reference",
			"theme" => "",
			"download_url" => "",
			"host" => "",
			"genre" => "string",
			"memo" => ""
		];
	}

}
