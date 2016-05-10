<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CreateBibleNoteCommand extends Command implements ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;
	
	public $bible_verse_id;
    public $body;
    public $userId;
    public $image_id;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(array $input)
	{
		$this->bible_verse_id = $input['bible_verse_id'];		
		$this->userId = $input['userId'];
    	$this->body = $input['body'];
    	$this->image_id =  $input['image_id'];    	
	}

}