<?php namespace BibleExperience\Events;

use BibleExperience\Events\Event;
use BibleExperience\Entities\User;

use Illuminate\Queue\SerializesModels;

class UserHasConfirmedEmail extends Event {

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