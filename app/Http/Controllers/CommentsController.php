<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Commands\LeaveCommentCommand;
use BibleExchange\Entities\Comment;
use Input, Auth, Redirect;

class CommentsController extends Controller {
	
	public function __construct()
	{
		
	}
	
	/**
	 * Leave a new comment.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = array_add(Input::get(), 'user_id', Auth::id());

        $this->dispatch(new LeaveCommentCommand($input));

        return Redirect::back();
	}
	
	public function delete($comment)
	{
			
		$user = Auth::user();   
	
		if ($comment->user_id === $user->id){
				
			Comment::destroy($comment->id);
			\Flash::success('Your comment has been deleted!');
	
		}else{
	
			\Flash::warning('You don\'t have permission to delete this!');
	
		}
	
		return Redirect::back();
	
	}
	
}