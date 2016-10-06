<?php namespace BibleExperience;

use Illuminate\Support\Facades\URL;
use BibleExperience\Core\PresentableTrait;
use BibleExperience\Core\ShortableTrait;
use BibleExperience\Core\UUIDTrait;
use BibleExperience\Presenters\Contracts\PresentableInterface;
use Str, Cache;

class Course extends \Eloquent implements PresentableInterface {
	
	protected $table = 'courses';
	public $fillable = array('bible_verse_id','library_id','title','description','user_id','public','image','created_at','updated_at');
	protected $appends = array('defaultImage','lessonsCount','uuid');

	protected $presenter = 'BibleExperience\Presenters\Course';
	
	use PresentableTrait, ShortableTrait, UUIDTrait;
	
	public static function make( $bible_verse_id, $title, $user_id, $public)
	{
		$course = new static(compact('bible_verse_id', 'title', 'user_id', 'public'));
	
		return $course;
	}
	
	public function lessons()
	{
		return $this->hasMany('\BibleExperience\Lesson','course_id');
	}

   public function library()
    {
    	return $this->belongsTo('BibleExperience\Library','bible_verse_id');
    }
	
   public function verse()
    {
    	return $this->belongsTo('BibleExperience\BibleVerse','bible_verse_id');
    }
	
/*	
	public function notes()
	{
		return $this->belongsToMany('\BibleExperience\Note')->withPivot('orderBy')->orderBy('orderBy','ASC');
	}
*/	
	    
    public function owner()
    {
    	return $this->belongsTo('BibleExperience\User','user_id');
    }

 public function getLessonsCountAttribute()
    {
	if($this->lessons === null){
	  return 0;
	}else{
	  return $this->lessons->count();
	}
    }

    public static function updateFromArray(Array $array_of_props)
    {
	
        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'course_id_was_not_given', 'code'=>500, 'course'=> new Course]);
        }else{

	  $course = Course::find($array_of_props['id']);
	
	  unset($array_of_props['id']);
	  unset($array_of_props['clientMutationId']);

	  foreach($array_of_props AS $key => $value){
	    $course->$key = $value;
	  }

	  try {
		$course->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'course'=> new Course]);
	  };

	  return ['error' => null, 'code'=>200, 'course'=> $course];

	}

       
    }

}
