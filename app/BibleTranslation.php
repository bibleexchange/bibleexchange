<?php namespace BibleExperience;

class BibleTranslation extends BaseModel {

	protected $table = 'bible_translations';
	public $timestamps = false;
	protected $fillable = array('translation','verse_id','text');

	public function verse()
	{
	    return $this->belongsTo('BibleExperience\BibleVerse', 'verse_id');
	}

	public function version(){
		 return $this->belongsTo('BibleExperience\BibleVersion', 'version_id');
	}

	public static function scopeKJVR($query)
	{
		return $query->where('version_id','1');
	}

}
