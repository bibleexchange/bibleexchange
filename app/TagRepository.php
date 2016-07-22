<?php namespace BibleExperience;

use BibleExperience\Tag;		

class TagRepository {
	
	public function __construct()
	{

	}
	
    public function save(Tag $tag)
    {
    	return $tag->save();
    }

} 