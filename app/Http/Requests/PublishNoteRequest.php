<?php namespace BibleExchange\Http\Requests;

use BibleExchange\Http\Requests\Request;

class PublishNoteRequest extends Request {

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
			'body'    => 'required|max:600',
			'bible_verse_id'    => 'required|reference',
		];
	}
	
}
