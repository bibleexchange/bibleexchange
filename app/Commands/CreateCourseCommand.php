<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;
use Str, Auth;

class CreateCourseCommand extends Command {

	public $shortname;
    public $slug;
    public $subtitle;
    public $title;
    public $user_id;
    
	
	public function __construct( $shortname, $slug, $subtitle, $title, $user)
	{
		
		$this->shortname = $shortname;
		$this->slug = $slug;
		$this->subtitle = $subtitle;
		$this->title = $title;
        $this->user = $user;
        
	}

}
