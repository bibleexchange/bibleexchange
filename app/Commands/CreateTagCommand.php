<?php namespace BibleExperience\Commands;

use BibleExperience\Commands\Command;

class CreateTagCommand extends Command {

	public $name;
	
	public function __construct($name)
	{
		$this->name = $name;
	}


}
