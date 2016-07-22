<?php namespace BibleExperience\Core;

trait CommentableTrait {

	public function comments()
	{
		return $this->morphMany('BibleExperience\Comment','commentable');
	}
	
}