<?php namespace BibleExchange\Http\Controllers;

class SubscriptionController extends \BaseController {

	/**
	 * Display a listing of subscriptions
	 *
	 * @return Response
	 */
	public function index()
	{
		$subscriptions = Subscription::all();

		return View::make('subscriptions.index', compact('subscriptions'));
	}

	/**
	 * Show the form for creating a new subscription
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('subscriptions.create');
	}

	/**
	 * Store a newly created subscription in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Subscription::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Subscription::create($data);

		return Redirect::route('subscriptions.index');
	}

	/**
	 * Display the specified subscription.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$subscription = Subscription::findOrFail($id);

		return View::make('subscriptions.show', compact('subscription'));
	}

	/**
	 * Show the form for editing the specified subscription.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$subscription = Subscription::find($id);

		return View::make('subscriptions.edit', compact('subscription'));
	}

	/**
	 * Update the specified subscription in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$subscription = Subscription::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Subscription::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$subscription->update($data);

		return Redirect::route('subscriptions.index');
	}

	/**
	 * Remove the specified subscription from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Subscription::destroy($id);

		return Redirect::route('subscriptions.index');
	}

}
