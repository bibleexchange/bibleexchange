<?php namespace BibleExperience\Entities;

class Module extends \Eloquent  {

	protected $table = 'modules';
	public $fillable = array('title','course_id','order_by','created_at','updated_at');
	
	public function course()
	{
	    return $this->belongsTo('BibleExperience\Entities\Course', 'course_id');
	}
	
	public function chapters()
	{
	    return $this->hasMany('BibleExperience\Entities\Chapter');
	}
	
	public function steps()
	{
		return $this->hasManyThrough('BibleExperience\Entities\Chapter','BibleExperience\Entities\Step')->groupBy('steps.chapter_id');
	}
	
}