<?php namespace BibleExperience;
 
class Section extends \Eloquent {
	
	protected $fillable = array('title','description','courses_id','orderBy','created_at','updated_at');

	public function course()
	{
	    return $this->belongsTo('\BibleExperience\Course', 'course_id');
	}
    
	public function studies()
	{
		return $this->belongsToMany('\BibleExperience\Study')->orderBy('orderBy','ASC')->orderBy('created_at','ASC');
	}
}