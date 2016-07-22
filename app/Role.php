<?php namespace BibleExperience;

class Role extends BaseModel {

	protected $fillable = ['name'];

	public function permissions()
    {
        return $this->belongsToMany('Permission');
    }
	
}
