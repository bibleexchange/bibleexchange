<?php namespace BibleExchange\Events;

use BibleExchange\Events\Event;
use BibleExchange\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserPasswordWasChanged extends Event {

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
