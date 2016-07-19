<?php namespace BibleExperience\Entities\Tasks;

use BibleExperience\Entities\Task;
use BibleExperience\Entities\Study;

class Read {

	public $template;
	
	public function __construct($task){
	
		$this->model = $task;
		$this->templates = new \stdClass();
		$this->templates->edit = 'studies.tasks.read.edit';
		
		return $this;
	
	}
	
}