<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class LeaveCommentCommand extends Command implements ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;
	
    /**
     * @var string
     */
    public $user_id;
    public $commentable_id;
    public $commentable_type;
    public $body;

    public function __construct(array $input)
    {    	
    	
        $this->user_id = $input['user_id'];
        $this->commentable_id = $input['commentable_id'];
        $this->commentable_type = $input['commentable_type'];
        $this->body = $input['body'];
    }

}