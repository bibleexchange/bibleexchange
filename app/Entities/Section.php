<?php namespace BibleExchange\Entities;
 
class Section extends \Eloquent {
	
	protected $fillable = array('title','description','courses_id','orderBy','created_at','updated_at');

	public function course()
	{
	    return $this->belongsTo('\BibleExchange\Entities\Course', 'course_id');
	}
    
	public function studies()
	{
		return $this->belongsToMany('\BibleExchange\Entities\Study')->orderBy('orderBy','ASC')->orderBy('created_at','ASC');
	}
}