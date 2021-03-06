<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Person extends BaseModel {

	protected $table = 'persons';
	
	protected $appends = ['fullname'];
	
	protected $fillable = [ 'prefix','firstname' , 'middlename' , 'lastname','suffix' , 'birth_date','death_date','memo','image','created_at','updated_at','deleted_at'];
	
	//protected $presenter = 'BibleExperience\Presenters\PersonPresenter';
	
	protected $dates = ['birth_date','death_date','created_at','updated_at','deleted_at'];
	
	public function recordings()
	{
		return $this->belongsToMany('BibleExperience\Recording', 'person_recording','person_id','recording_id')->withPivot('role', 'memo');
	}

	public function getFullnameAttribute()
	{
		return $this->firstname.' '.$this->middlename.' '.$this->lastname.' '.$this->suffix;
	}
	
}
