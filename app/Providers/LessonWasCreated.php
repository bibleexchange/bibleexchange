<?php namespace BibleExperience\Providers;

use BibleExperience\Events\Event;

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
