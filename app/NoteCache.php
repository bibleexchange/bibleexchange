<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class NoteCache extends Model {

    protected $fillable = ['type','api_request','body','note_id','created_at','updated_at'];

    public function note()
    {
    	return $this->belongsTo('BibleExperience\Note','note_id');
    }

}
