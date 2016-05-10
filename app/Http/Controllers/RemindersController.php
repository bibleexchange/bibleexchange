<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Http\Requests\ResetPasswordRequest;
use BibleExchange\Commands\SendPasswordResetCommand;
use BibleExchange\Commands\ChangePasswordCommand;
use BibleExchange\Http\Requests\ChangePasswordRequest;
use BibleExchange\Entities\UserRepository;
use BibleExchange\Entities\PasswordReset;

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return view('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind(ResetPasswordRequest $request)
	{
		
		$email = \Input::get('email');
		
		$this->dispatch(new SendPasswordResetCommand($email));
		
		\Auth::logout();
		
		\Flash::message('We just emailed a password reset link to '.$email.'.');
		
		return \Redirect::to('/welcome');
	}

	public function postResendConfirmationEmail()
	{

		Flash::message('A confirmation email has been resent');
		
		return Redirect::back();

	}
	
	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		
		if (is_null($token) or PasswordReset::where('token',$token)->first() === null){
			
			\Flash::error('That reset token doesn\'t exist anymore.');
			
			if (\Auth::check()){
			
			return \Redirect::to('/');
			}else {
				return \Redirect::to('/welcome');
			}
		}
		
		return view('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset(ChangePasswordRequest $request)
	{
		$email = \Input::get('email');
		$user = UserRepository::findByEmail($email);
		$newPassword = \Input::get('password');
		
		$this->dispatch(new ChangePasswordCommand($user, $newPassword));
		\Auth::logout();
        \Flash::success('Your password has been reset. You may now log in.');
		
		return \Redirect::to('/welcome');
		
	}

}
