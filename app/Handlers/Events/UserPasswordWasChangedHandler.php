<?php namespace BibleExchange\Handlers\Events;

use BibleExchange\Events\UserPasswordWasChanged;
use BibleExchange\Mailers\UserMailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use BibleExchange\Entities\PasswordReset;

class UserPasswordWasChangedHandler {

	/**
	 * @var UserMailer
	 */
	private $mailer;
	
	/**
	 * @param UserMailer $mailer
	 */
	public function __construct(UserMailer $mailer)
	{
		$this->mailer = $mailer;
	}
	
	/**
	 * Handle the event.
	 *
	 * @param  UserWasRegistered  $event
	 * @return void
	 */
	public function handle(UserPasswordWasChanged $event)
	{
		$this->mailer->sendPasswordChangedMessageTo($event->user);
		
		PasswordReset::where('user_id',$event->user->id)->delete();
	}

}
