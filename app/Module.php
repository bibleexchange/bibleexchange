<?php namespace BibleExperience;

class Module extends \Eloquent  {

	protected $table = 'modules';
	public $fillable = array('title','course_id','order_by','created_at','updated_at');
	
	public function course()
	{
	    return $this->belongsTo('BibleExperience\Course', 'course_id');
	}
	
	public function chapters()
	{
	    return $this->hasMany('BibleExperience\Chapter');
	}
	
	public function steps()
	{
		return $this->hasManyThrough('BibleExperience\Chapter','BibleExperience\Step')->groupBy('steps.chapter_id');
	}
	
}