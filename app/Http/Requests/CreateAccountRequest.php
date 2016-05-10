<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;
use Auth;

class CreateAccountRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if(Auth::user() === null){ return true; }
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8|confirmed',
			'password_confirmation' => 'min:8'
		];
	}

}
