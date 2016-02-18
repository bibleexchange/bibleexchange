<?php namespace BibleExchange\Entities;

class Collection extends \Eloquent {
	protected $fillable = [
 'firstname' , 'lastname' , 'prefix' , 'middlename' , 'suffix' , 'birthday' , 'memo', 'image'
	];

	protected $table = 'collections';
			
	public static $rules = array(
	  'firstname' =>'required',
	  'lastname' =>'required',
	  'prefix' =>'',
	  'middlename' =>'',
	  'suffix' =>'',
	  'Birthday' =>'',
	  'memo' =>'',
	  'image' =>'',
	  'created_at' =>'integer',
	  'updated_at' =>'integer'
    );
	
	public function contacts()
	  {
		return $this->belongsToMany('Contact');
	  }
	
	public function courses()
	  {
		return $this->belongsToMany('Course')->orderBy('collection_course.sequence');
	  }
	
	public function coursesPublic()
	  {
		return $this->belongsToMany('Course')
			->orderBy('collection_course.sequence')
			->where('courses.webReady','=',1);
	  }
	
}