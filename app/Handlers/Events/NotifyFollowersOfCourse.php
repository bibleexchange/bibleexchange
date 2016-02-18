<?php namespace BibleExchange\Handlers\Events;

use BibleExchange\Events\CourseWasCreated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class NotifyFollowersOfCourse {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Events  $event
	 * @return void
	 */
	public function handle(CourseWasCreated $event)
	{
		$sender = $event->user;
		
		//Notify Course Creators Followers
		foreach ($sender->followers As $follower)
		{				
				
			$follower->newNotification()
			->withSubject($sender->firstname.' created a new course.')
			->withBody('Check out '.$sender->firstname.'&apos;s  new course "'.$event->course->title.'".')
			->withSender($sender->id)
			->regarding($event->course)
			->deliver();
		}
		
	}
	
}
