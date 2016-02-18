<?php namespace BibleExchange\Handlers\Events;

use BibleExchange\Events\UserWasRegistered;
use BibleExchange\Mailers\UserMailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendRegistrationConfirmation implements ShouldBeQueued {
	
	use InteractsWithQueue;
	
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
	public function handle(UserWasRegistered $event)
	{		
		$this->mailer->sendConfirmMessageTo($event->user);
	}

}
