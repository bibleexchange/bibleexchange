<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel {

	protected $fillable = ['name'];
	
	public static function make($name)
	{
		$tag = new static(compact('name'));
	
		return $tag;
	}
	
	public function studies(){
		
		return $this->belongsToMany('BibleExperience\Tag');
		
	}
	
}
