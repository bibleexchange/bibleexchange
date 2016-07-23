<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    protected $fillable = ['name','display_name'];
	
	public function roles()
    {
        return $this->belongsToMany('Role');
    }
	
}
