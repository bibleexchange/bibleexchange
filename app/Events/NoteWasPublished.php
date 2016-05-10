<?php namespace BibleExchange\Events;

use BibleExchange\Events\Event;

use Illuminate\Queue\SerializesModels;

class NoteWasPublished extends Event {

	use SerializesModels;
	public $note;
	
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($note)
	{
		$this->note = $note;
	}

}