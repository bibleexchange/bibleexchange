<?php namespace BibleExperience\Entities;

class Step extends \Eloquent  {

	protected $table = 'steps';
	public $fillable = array('body','chapter_id','order_by','created_at','updated_at');
	
	public function chapter()
	{
	    return $this->belongsTo('BibleExperience\Entities\Chapter', 'chapter_id');
	}
	
}