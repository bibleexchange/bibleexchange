<?php namespace BibleExperience\Tasks;

use BibleExperience\Task;

class Test {
 	
	public $template;
	
	public function __construct($task){
		
		$this->model = $task;
		$this->templates = new \stdClass();
		$this->templates->edit = 'studies.tasks.test.edit';
		
		return $this;
	}
	
}