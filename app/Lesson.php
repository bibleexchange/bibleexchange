<?php namespace BibleExperience;

use Str,stdClass;
use BibleExperience\Course;

class Lesson extends BaseModel {

	protected $table = 'lessons';
	protected $fillable = array('course_id','order_by','title','description');
	protected $appends = array('previous','next','activitiesCount');

	public function course()
	{
		return $this->belongsTo('\BibleExperience\Course','course_id');
	}

	public function activities()
	{
	  return $this->hasMany('\BibleExperience\Activity');
	}

	public function statements()
	{
		return $this->hasManyThrough('\BibleExperience\Statement','\BibleExperience\Activity');
	}

	public function getActivitiesCountAttribute()
	{
		return $this->activities->count();
	}

	public function getNextAttribute()
  {
  	return $this->course->lessons()->where('lessons.order_by','>',$this->order_by)->first();
  }

  public function getPreviousAttribute()
  {
  	return $this->course->lessons()->where('lessons.order_by','<',$this->order_by)->first();
  }

/*
  public static function updateFromArray(Array $array_of_props)
    {

        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'lesson'=> null]);
        }else{

	  $lesson = Lesson::find($array_of_props['id']);

	  unset(
	  	$array_of_props['id'],
	  	$array_of_props['clientMutationId'],
	  	$array_of_props['token']
	  	);

	  foreach($array_of_props AS $key => $value){
	    if ($key === "body"){

	    	$body = new LessonBody;
	  		$body->lesson_id = $lesson->id;
	  		$body->text = $array_of_props["body"];
	  		$body->save();
	  		$lesson->body_id = $body->id;
	    	
	    }else{
	    	$lesson->$key = $value;
	    }
	  }

	  try {

		$lesson->save();
	  }catch(Exception $e){

		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lesson'=> $lesson]);
	  };

	  return ['error' => null, 'code'=>200, 'lesson'=> $lesson];

	}


    }

  public static function createFromArray(Array $array_of_props)
    {

	  $lesson = new Lesson;

	  if(!isset($array_of_props["order_by"])){
	  	$course = Course::find($array_of_props["course_id"]);
	  	$array_of_props["order_by"] = $course->lessons->count() + 1;
	  }

	  foreach($array_of_props AS $key => $value){

	  		if($key !== "body"){
	    		$lesson->$key = $value;
	  		}
	  }

	  try {
		$lesson->save();

	  	if(isset($array_of_props["body"])){
	    	$body = new LessonBody;
	  		$body->lesson_id = $lesson->id;
	  		$body->text = $array_of_props["body"];
	  		$body->save();

	  		$lesson->body_id = $body->id;
	  		$lesson->save();
	  	}
	  	

	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'lesson'=> $lesson]);
	  };

	  return ['error' => null, 'code'=>200, 'lesson'=> $lesson];

    }
*/
}
