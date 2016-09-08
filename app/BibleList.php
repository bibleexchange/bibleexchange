<?php namespace BibleExperience;

use Str,stdClass;

class BibleList extends \Eloquent {
	
	//protected $connection = 'scripture';
	protected $table = 'biblelists';
	protected $fillable = array('name','description');
	protected $appends = array();
	
	public function verses()
	{
	    return $this->belongsToMany('BibleExperience\BibleVerse','bibleverse_biblelist','biblelist_id','bibleverse_id');
	}
	
}
