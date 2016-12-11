<?php namespace BibleExperience\Ez;

class EzForm {
	
	function __construct($method, $action, array $fields,  $header = ''){
		$this->method = $method;
		$this->action = $action;
		$this->token = csrf_token();	
		$this->fields = $this->setFields($fields);	
		$this->header = $header;
	}
	
	function setFields($fields){
		
		$csrf_field = ["type"=>"hidden", "name"=>"_token", "value"=>$this->token];
		$fields[] = $csrf_field ;

		return $fields;
		
	}
	
	function all(){
		
		$x = new \stdClass();
		$x->method = $this->method;
		$x->action = $this->action;
		$x->token = $this->token;
		$x->fields = $this->fields;
		$x->header = $this->header;
		
		return json_encode($x, true);
		
	}
	
}