<?php namespace BibleExchange\Entities\Tasks;

use BibleExchange\Entities\Task;

class Apply {
 	
	public $template;
	
	public function __construct($task){
		
		$this->model = $task;
		$this->templates = new \stdClass();
		$this->templates->edit = 'studies.tasks.apply.edit';
		
		return $this;
	}
	
}