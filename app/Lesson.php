<?php namespace BibleExperience;

use Str,stdClass;
use BibleExperience\Core\UUIDTrait;

class Lesson extends \Eloquent {


	use UUIDTrait;	//be sure to add "uui" to $appends array

	protected $table = 'lessons';
	protected $fillable = array('course_id','order_by','title','summary');
	protected $appends = array('uuid','previous','next','notesCount');

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

	public function getNextAttribute()
	    {

		if ($this->order_by >= $this->course->lessons->count()){
		  return null;
		}else{
		  return $this->course->lessons()->where('order_by',$this->order_by+1)->first();
		}


	    }

    public function getPreviousAttribute()
    {
	if ($this->order_by <= 1){
	  return null;
	}else{
	  return $this->course->lessons()->where('order_by',$this->order_by-1)->first();
	}
    }
}
