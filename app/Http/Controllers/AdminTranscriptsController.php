<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Entities\User;

class AdminTranscriptsController extends \AdminController {

	/**
	 * Display a listing of the resource.
	 * GET /transcripts
	 *
	 * @return Response
	 */
	public function index()
	{
		$students = User::with('transcripts')->has('transcripts')->get();

		return View::make('transcripts.index',compact('students'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /transcripts/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('transcripts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /transcripts
	 *
	 * @return Response
	 */
	public function store()
	{
		;
	}

	/**
	 * Display the specified resource.
	 * GET /transcripts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($userId)
	{
		
		$userWithTranscripts = User::with('transcripts')->find($userId);

		return View::make('transcripts.show',compact('userWithTranscripts'));
	}
	
	/**
	 * Show the form for editing the specified resource.
	 * GET /transcripts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return View::make('transcripts.edit');
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /transcripts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /transcripts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}