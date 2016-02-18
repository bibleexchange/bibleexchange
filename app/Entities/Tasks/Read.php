<?php namespace BibleExchange\Entities\Tasks;

use BibleExchange\Entities\Task;
use BibleExchange\Entities\Study;

class Read {

	public $template;
	
	public function __construct($task){
	
		$this->model = $task;
		$this->templates = new \stdClass();
		$this->templates->edit = 'studies.tasks.read.edit';
		
		return $this;
	
	}
	
}