<?php namespace BibleExchange\Events;

use BibleExchange\Events\Event;

use Illuminate\Queue\SerializesModels;

class CourseWasCreated extends Event {

	use SerializesModels;
	
	public $course;
	public $user;
	
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($course, $user)
	{
		$this->course = $course;
		$this->user = $user;
	}

}
