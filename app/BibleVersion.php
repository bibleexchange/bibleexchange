<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class BibleVersion extends BaseModel {

	protected $table = 'bible_versions';
	
	public $timestamps = false;
	
	protected $fillable = ['name','short'];
	
}
