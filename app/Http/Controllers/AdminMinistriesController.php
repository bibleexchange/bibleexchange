<?php namespace BibleExchange\Http\Controllers;

class AdminMinistriesController extends \BaseController {

	/**
	 * Display a listing of ministries
	 *
	 * @return Response
	 */
	public function index()
	{
		$ministries = Ministry::all();

		return View::make('ministries.index', compact('ministries'));
	}

	/**
	 * Show the form for creating a new ministry
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('ministries.create');
	}

	/**
	 * Store a newly created ministry in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Ministry::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Ministry::create($data);

		return Redirect::route('ministries.index');
	}

	/**
	 * Display the specified ministry.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$ministry = Ministry::findOrFail($id);

		return View::make('ministries.show', compact('ministry'));
	}

	/**
	 * Show the form for editing the specified ministry.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ministry = Ministry::find($id);

		return View::make('ministries.edit', compact('ministry'));
	}

	/**
	 * Update the specified ministry in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$ministry = Ministry::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Ministry::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$ministry->update($data);

		return Redirect::route('ministries.index');
	}

	/**
	 * Remove the specified ministry from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Ministry::destroy($id);

		return Redirect::route('ministries.index');
	}

}
