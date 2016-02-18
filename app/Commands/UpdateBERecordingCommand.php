<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;
use BibleExchange\Helpers\Helpers as Helper;

class UpdateBERecordingCommand extends Command {
	
	public $recording;
	public $date;
	public $dated;
    public $description;
    public $genre;
    public $title;
	
	public function __construct($recording, $input)
	{
		$this->recording = $recording;
		
		if (is_array($input)){
			$input = (object) $input;
		}

		$this->date = $input->date;
		$this->dated = $input->dated;
		$this->description = $input->description;
		$this->genre = $input->genre;
		$this->title = $input->title;
               
	}

}
