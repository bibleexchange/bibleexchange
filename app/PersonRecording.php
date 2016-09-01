<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class PersonRecording extends Model {

	protected $table = 'person_recording';
		
	protected $fillable = [ 'recording_id','person_id','role','memo'];
	
	public $timestamps = false;
	
}
