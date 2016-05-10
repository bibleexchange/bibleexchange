<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;

class UpdateProfileRequest extends Request {

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
		'firstname' => 'required',
		'middlename' => 'required',
		'lastname' => 'required',
		'suffix'=>'',
		'gender'=>'required',
		'profile_image'=>'',
		'location'=>''
		];
	}

}
