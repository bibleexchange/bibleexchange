<?php namespace BibleExchange\Events;

use BibleExchange\Events\Event;
use Illuminate\Queue\SerializesModels;
use BibleExchange\Entities\User;

class UserAskedForRegistrationConfirmation extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user)
	{		
		$this->user = $user;
	}

}
