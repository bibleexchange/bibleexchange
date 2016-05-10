<?php namespace BibleExchange\Entities\Transformers;

class CommentTransformer extends Transformer{

	public function transform($comment)
	{
	
		return [
				'app_id'=> $comment->id,
				'study_app_id'=> $comment->commentable_id, 
				'author'=> $comment->owner->fullname,
				'author_profile' => $comment->owner->profileURL(),
				'body'=> $comment->body,
				'avatar_path'=> $comment->owner->present()->gravatar(30)
		];
		
	}
	
}