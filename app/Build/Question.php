<?php namespace BibleExperience\Build;

class Question {

	function __construct($question_array){
		$this->data = $question_array;
		$this->id = null;
		$this->body = null;
		$this->type = [];
		$this->options = [];
		$this->activity = null;

		$this->initialize();

	}

	function initialize(){
		$this->setId()->setBody()->setType()->setOptions()->setActivity();
	}

	function setId(){
		if(isset($this->data->id)){
			$this->id = $this->data->id;
		}else if($this->data->body){
			$this->id = base64_encode($this->data->body);
		}
		return $this;
	}

	function setBody(){
		if(isset($this->data->body)){
			$this->body = $this->data->body;
		}
		return $this;
	}

	function setType(){
		if(isset($this->data->type)){
			$this->type = $this->data->type;
		}
		return $this;
	}

	function setOptions(){
		if(isset($this->data->options)){
			$this->options = $this->data->options;
		}
		return $this;
	}

		function setActivity(){
			if(isset($this->data->options)){
				$activity = '';

				switch($this->type){

					case "MULTIPLE_CHOICE":

						  foreach($this->options AS $o){
								$activity .= '<input type="radio" name="'.$this->id.'" value="'.$o->display.'">'.$o->display.'<br>';
							}

						break;

					case "FILL_IN_THE_BLANK":

							$activity = $this->body;

							foreach($this->options AS $o){
								$activity = str_replace($o, "__________________", $activity);
							}
							$activity = "<textarea name='".$this->id."'>".$activity."</textarea>";
							$this->body = "Replace the blanks with the correct words: ";

						break;

					default:
						$activity = null;

				}



				$this->activity = $activity;
			}
			return $this;
		}

}
