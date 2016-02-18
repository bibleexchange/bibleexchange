<?php namespace BibleExchange\Entities;

use BibleExchange\Entities\Tag;		

class TagRepository {
	
	public function __construct()
	{

	}
	
    public function save(Tag $tag)
    {
    	return $tag->save();
    }

} 