<?php namespace BibleExchange\Core;

trait CommentableTrait {

	public function comments()
	{
		return $this->morphMany('BibleExchange\Entities\Comment','commentable');
	}
	
}