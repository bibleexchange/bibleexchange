<?php namespace BibleExchange\Events;

use BibleExchange\Events\Event;

use Illuminate\Queue\SerializesModels;

class LessonWasCreated extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

}
