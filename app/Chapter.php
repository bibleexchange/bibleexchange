<?php namespace BibleExperience;

class Chapter extends \Eloquent  {

	protected $table = 'chapters';
	public $fillable = array('title','module_id','order_by','created_at','updated_at');
	
	public function module()
	{
	    return $this->belongsTo('BibleExperience\Module', 'module_id');
	}
	
	public function steps()
	{
	    return $this->hasMany('BibleExperience\Step');
	}
	
}