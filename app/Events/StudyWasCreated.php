<?php namespace BibleExperience\Events;

use BibleExperience\Events\Event;

use Illuminate\Queue\SerializesModels;

class StudyWasCreated extends Event {

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
