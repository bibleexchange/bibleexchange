<?php namespace BibleExchange\Entities;

class Chapter extends \Eloquent  {

	protected $table = 'chapters';
	public $fillable = array('title','module_id','order_by','created_at','updated_at');
	
	public function module()
	{
	    return $this->belongsTo('BibleExchange\Entities\Module', 'module_id');
	}
	
	public function steps()
	{
	    return $this->hasMany('BibleExchange\Entities\Step');
	}
	
}