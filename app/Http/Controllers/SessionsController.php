<?php namespace BibleExchange\Http\Controllers;

use Input, Auth, Flash, Redirect;

class SessionsController extends Controller {

	/**
	 * @var SignInForm
	 */
	private $signInForm;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest',['except' => ['destroy']]);
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(\BibleExchange\Http\Requests\SigninRequest $request)
	{
		$formData = Input::only('email', 'password');
		
		if ( ! Auth::attempt($formData, Input::get('remember')))
		{
			Flash::error('We were unable to sign you in. Please check your credentials and try again!');
	
			return Redirect::back()->withInput();
		}
	
		Flash::success('Welcome back!');
		
		if (Input::get('redirect') !== null && ! Auth::user()->isConfirmed())
		{
			return Redirect::to(Input::get('redirect'));
		}
		
		return Redirect::intended('/');
	}
	
	/**
	 * Log a user out of BibleExchange.
	 *
	 * @return mixed
	 */
	public function destroy()
	{
		Auth::logout();
	
		Flash::message('You have now been logged out.');
	
		return Redirect::back();
	}
	
}