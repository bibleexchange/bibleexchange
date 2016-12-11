<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Test extends Model {

	protected $fillable = ['title','body'];
	    
	protected $appends = [];
	
	public $timestamps = false;
	
	public static function make($title, $body)
	{

		$test = new static(compact('title', 'body'));
	
		return $test;
	}

	public function owner()
	{
		return $this->belongsTo('\BibleExperience\User');
	}
	
}
