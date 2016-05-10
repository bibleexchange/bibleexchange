<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;
use BibleExchange\Helpers\Helpers as Helper;

class CreateBEStudyCommand extends Command {
	
	public $description;
	public $namespace_id;
	public $text;
    public $title;
    public $user_id;
    public $comment;
    public $minor_edit;
	
	public function __construct($description,$title, $user_id, $text, $comment, $minor_edit)
	{
		$this->description = $description;
		$this->namespace_id = 1;
		$this->text = $text;
		$this->title = Helper::userTitleToUrl($title);
        $this->user_id = $user_id;
        $this->comment = $comment;
        $this->minor_edit = $minor_edit;
                
	}

}
