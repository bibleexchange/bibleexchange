<?php

class EzForm {
	
	function __construct($method, $action, array $fields){	
		$this->method = $method;
		$this->action = $action;
		$this->token = csrf_token();	
		$this->fields = $this->setFields($fields);				
	}
	
	function setFields($fields){
		
		$csrf_field = ["type"=>"hidden", "name"=>"_token", "value"=>$this->token];
		$fields[] = $csrf_field ;

		return $fields;
		
	}
	
	function all(){
		
		$x = new stdClass();
		$x->method = $this->method;
		$x->action = $this->action;
		$x->token = $this->token;
		$x->fields = $this->fields;
		
		return json_encode($x, true);
		
	}
	
}