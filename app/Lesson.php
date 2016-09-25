<?php namespace BibleExperience;

use Str,stdClass;
use BibleExperience\Core\UUIDTrait;

class Lesson extends \Eloquent {


	use UUIDTrait;	//be sure to add "uui" to $appends array

	protected $table = 'lessons';
	protected $fillable = array('course_id','order_by','title','summary');
	protected $appends = array('uuid','previousLesson','nextLesson','notesCount');

	public function course()
	{
		return $this->belongsTo('\BibleExperience\Course','course_id');
	}

	public function notes()
	{
	    return $this->hasMany('\BibleExperience\LessonNote');
	}

	public function getNotesCountAttribute()
	{
	    	if($this->notes === null){
		  return 0;
		}else{
		  return $this->notes->count();
		}
	}

	public function getNextLessonAttribute()
	    {
		if($this->id === null){return new BibleChapter;}

		if ($this->id == 1189){
			$chapter = $this->find(1);
		}else{
			$chapter = $this->find($this->id+1);
		}

		  return $chapter;
	    }

	public function getPreviousLessonAttribute()
    {
		if($this->id === null){return new BibleChapter;}

		if ($this->id == 1){
			$chapter = $this->find(1189);
		}else{
			$chapter = $this->find($this->id-1);
		}

	  return $chapter;
    }
}
