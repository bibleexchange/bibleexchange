<?php namespace BibleExchange\Entities;

class PostRepository {
	
	public $source;
	public $posts;
	
	function construct()
	{
		
	}
	
	public function all()
	{
		dd($this->build());
		return $this->posts;	
	}
	
	public function build()
	{
		
		$this->source = base_path().'/resources/docs/blog';
		
		$this->posts = $files = preg_grep('/^([^.])/', scandir($this->source));
		
		return $this;
	}

}
