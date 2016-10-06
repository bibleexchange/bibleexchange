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

  public static function updateFromArray(Array $array_of_props)
    {
	
        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'lesson'=> new Lesson]);
        }else{

	  $lesson = Lesson::find($array_of_props['id']);
	
	  unset($array_of_props['id']);

	  foreach($array_of_props AS $key => $value){
	    if (isset($lesson->$key)){
	    	$lesson->$key = $value;
	    }
	  }

	  try {
		$lesson->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lesson'=> new Lesson]);
	  };

	  return ['error' => null, 'code'=>200, 'lesson'=> $lesson];

	}

       
    }

  public static function createFromArray(Array $array_of_props)
    {

	  $lesson = new Lesson;
	  unset($array_of_props['clientMutationId']);	
	  unset($array_of_props['id']);

	  foreach($array_of_props AS $key => $value){
	    	$lesson->$key = $value;
	  }

	  try {
		$lesson->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lesson'=> $lesson]);
	  };

	  return ['error' => null, 'code'=>200, 'lesson'=> $lesson];
       
    }

}
