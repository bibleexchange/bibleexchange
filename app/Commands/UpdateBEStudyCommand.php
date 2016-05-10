<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;
use BibleExchange\Helpers\Helpers as Helper;

class UpdateBEStudyCommand extends Command {
	
	public $study;
	public $namespace_id;
	public $text;
    public $user_id;
    public $comment;
    public $minor_edit;
	
	public function __construct($study, $user_id, $text, $comment, $minor_edit)
	{

		$this->study = $study;
		$this->namespace_id = 1;
		$this->text = $text;
        $this->user_id = $user_id;
        $this->comment = $comment;
        $this->minor_edit = $minor_edit;
                
	}

}
