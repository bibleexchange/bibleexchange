<?php namespace BibleExchange\Entities\Tasks;

use BibleExchange\Entities\Task;

class Review {
 	
	public $template;
	
	public function __construct($task){
		
		$this->model = $task;
		$this->templates = new \stdClass();
		$this->templates->edit = 'studies.tasks.review.edit';
		
		return $this;
	}
	
}