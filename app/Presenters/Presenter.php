<?php namespace BibleExchange\Presenters;

abstract class Presenter {

protected $entity;

	function __construct($entity){
	
		$this->entity = $entity;
	
	}
	
	public function __get($property){
	
		if (method_exists($this, $property)){
				
			return $this->{$property}();
				
		}
	
		return $this->entity->{$property};
	}
	
}
