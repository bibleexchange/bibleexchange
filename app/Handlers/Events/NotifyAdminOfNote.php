<?php namespace BibleExchange\Handlers\Events;

use BibleExchange\Events\NoteWasPublished;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class NotifyAdminOfNote {

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
	public function handle(NoteWasPublished $event)
	{
		//dd($event);
	}

}
