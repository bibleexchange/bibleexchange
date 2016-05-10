<?php namespace BibleExchange\Http\Controllers;
/*
$name = 'Stephen';
$logo = 'http://www.bible.exchange/assets/be_logo.png';

Mail::send('emails.test',compact('name','logo'),function($message)
{
	$message->to('sgrjr@deliverance.me')
		->subject('Mandrill Test');
});*/
class EmailsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /emails
	 *
	 * @return Response
	 */
	public function index()
	{
		$emails = Email::all();
		
		return View::make('emails.index', compact('emails'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /emails/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /emails
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /emails/{id}
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
	 * GET /emails/{id}/edit
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
	 * PUT /emails/{id}
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
	 * DELETE /emails/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}