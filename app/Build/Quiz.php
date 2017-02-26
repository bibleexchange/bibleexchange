<?php namespace BibleExperience\Build;

use BibleExperience\Build\Question;

class Quiz {

	function __construct($json_string){
		$this->data = $json_string;

		$this->title = null;
		$this->instructions = null;
		$this->questions = [];

		$this->initialize();

	}

	function initialize(){
		$this->setTitle()->setInstructions()->setQuestions();
	}

	function setTitle(){
		if(isset($this->data->title)){
			$this->title = $this->data->title;
		}
		return $this;
	}

	function setInstructions(){
		if(isset($this->data->instructions)){
			$this->instructions = $this->data->instructions;
		}
		return $this;
	}

	function setQuestions(){
		if(isset($this->data->questions)){
			$this->questions = $this->buildQuestions($this->data->questions);
		}
		return $this;
	}

	function buildQuestions($questions_array){

		$list = [];

		foreach($questions_array AS $q){
			$list[] = new Question($q);
		}
		return $list;
	}

}
