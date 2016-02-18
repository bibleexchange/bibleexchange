<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;

class ChangePasswordRequest extends Request {

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
			'email'    => 'required|email|exists:users',
			'password' => 'required|min:8|confirmed',
			'password_confirmation' => 'min:8',
			'token'=> 'required|exists:password_resets'
		];
	}

}
