<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\LeaveCommentCommand;
use Illuminate\Queue\InteractsWithQueue;
use BibleExperience\Entities\Comment;

class LeaveCommentCommandHandler {
	
	private $model;
	
	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct(Comment $model)
	{
		$this->model = $model;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CreateBibleNoteCommand  $command
	 * @return void
	 */
	public function handle(LeaveCommentCommand $command)
	{
		
		$comment = Comment::publish(
				$command->body, 
				$command->commentable_id,
				$command->commentable_type,
				$command->user_id
				);
		
		$comment->save();
		
		return $comment;
	}
}
