<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class BibleTranslation extends Model {
	
	protected $table = 'bible_translations';
	public $timestamps = false;
	protected $fillable = array('translation','verse_id','text');
	
	public function verse()
	{
	    return $this->belongsTo('BibleExchange\Entities\BibleVerse', 'verse_id');
	}
	
	public function version(){
		 return $this->belongsTo('BibleExchange\Entities\BibleVersion', 'version_id');
	}
	
	public static function scopeKJVR($query)
	{
		return $query->where('version_id','1');
	}
	
}
