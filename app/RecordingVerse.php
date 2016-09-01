<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class RecordingVerse extends Model {

	protected $table = 'recording_verse';
		
	protected $fillable = [ 'recording_id','verse_id'];
	
	public $timestamps = false;
	
	public function recording()
	{
	    return $this->belongsTo('BibleExperience\Recording', 'recording_id');
	}
	
	public function verse()
	{
	    return $this->belongsTo('BibleExperience\BibleVerse', 'verse_id');
	}
}
