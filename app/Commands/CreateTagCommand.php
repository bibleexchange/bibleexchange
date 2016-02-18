<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;

class CreateTagCommand extends Command {

	public $name;
	
	public function __construct($name)
	{
		$this->name = $name;
	}


}
