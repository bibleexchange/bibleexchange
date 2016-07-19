<?php

class Role extends Model {

	protected $fillable = ['name'];

	public function permissions()
    {
        return $this->belongsToMany('Permission');
    }
	
}
