<?php namespace BibleExperience;

use Str,stdClass;
use BibleExperience\Lesson;

class LessonBody extends BaseModel {

	protected $table = 'bodies';
	protected $fillable = array('text','lesson_id','created_at','updated_at');
	protected $appends = array();

	public function lesson()
	{
	    return $this->belongsTo('BibleExperience\Lesson');
	}

}
