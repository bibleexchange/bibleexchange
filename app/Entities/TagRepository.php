<?php namespace BibleExperience\Entities;

use BibleExperience\Entities\Tag;		

class TagRepository {
	
	public function __construct()
	{

	}
	
    public function save(Tag $tag)
    {
    	return $tag->save();
    }

} 