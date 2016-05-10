<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;
use BibleExchange\Helpers\Helpers as Helper;

class CreateBERecordingCommand extends Command {
	
	public $date;
	public $dated;
    public $description;
    public $genre;
    public $title;
	
	public function __construct($input)
	{
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
