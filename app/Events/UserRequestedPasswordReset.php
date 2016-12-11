<?php namespace BibleExperience\Events;

use BibleExperience\Events\Event;
use BibleExperience\User;

use Illuminate\Queue\SerializesModels;

class UserRequestedPasswordReset extends Event {

	use SerializesModels;

	public $user;

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