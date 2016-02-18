<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests;
use BibleExchange\Http\Controllers\Controller;
use Input, Redirect;
use Illuminate\Http\Request;

use BibleExchange\Entities\Question;

class QuestionsController extends Controller {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($study, $task)
	{
		
		$question = Question::create([
				'task_id'=>$task->id,
				'question'=>Input::get('question'),
				'answer'=>Input::get('answer'),
				'readable_answer'=>Input::get('readable_answer'),
				'options'=>Input::get('options'),
				'weight'=>Input::get('weight'),
				'question_type_id'=>Input::get('question_type_id')
		]);
		$question->save();
		
		return Redirect::back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($study, $task)
	{
		$question = Question::find(Input::get('question_id'));
		
		$question->update([
				'task_id'=>$task->id,
				'question'=>Input::get('question'),
				'answer'=>Input::get('answer'),
				'readable_answer'=>Input::get('readable_answer'),
				'options'=>Input::get('options'),
				'weight'=>Input::get('weight'),
				'question_type_id'=>Input::get('question_type_id')
		]);
		
		$question->save();
		
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
