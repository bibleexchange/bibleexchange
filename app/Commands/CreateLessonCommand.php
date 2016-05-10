<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;
use Str, Auth;

class CreateLessonCommand extends Command {

    public $title;

    public $user_id;
    
    public $slug;
    
    public $content;
	
	public function __construct($title, $user_id, $slug, $content=null)
	{
		$this->title = $title;
        $this->user_id = $user_id;
        $this->slug = $slug;
        $this->content = $content;
	}

}
