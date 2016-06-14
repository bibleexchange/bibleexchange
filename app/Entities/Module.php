<?php namespace BibleExchange\Entities;

class Module extends \Eloquent  {

	protected $table = 'modules';
	public $fillable = array('title','course_id','order_by','created_at','updated_at');
	
	public function course()
	{
	    return $this->belongsTo('BibleExchange\Entities\Course', 'course_id');
	}
	
	public function chapters()
	{
	    return $this->hasMany('BibleExchange\Entities\Chapter');
	}
	
	public function steps()
	{
		return $this->hasManyThrough('BibleExchange\Entities\Chapter','BibleExchange\Entities\Step')->groupBy('steps.chapter_id');
	}
	
}