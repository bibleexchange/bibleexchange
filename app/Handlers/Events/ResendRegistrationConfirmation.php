<?php namespace BibleExchange\Handlers\Events;

use BibleExchange\Events\UserAskedForRegistrationConfirmation;
use BibleExchange\Mailers\UserMailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ResendRegistrationConfirmation {
	
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
	public function handle(UserAskedForRegistrationConfirmation $event)
	{
		$this->mailer->sendConfirmMessageTo($event->user);
	}

}
