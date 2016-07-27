<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class CrossReference extends BaseModel {

	protected $table = 'cross_reference';
	protected $fillable = ['vid','r','sv','ev'];
	
	public function verse(){
	
		return $this->belongsTo('BibleExperience\BibleVerse','vid');
	}

}
