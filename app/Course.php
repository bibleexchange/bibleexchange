<?php namespace BibleExperience;

use Illuminate\Support\Facades\URL;
use BibleExperience\Core\PresentableTrait;
use BibleExperience\Core\ShortableTrait;
use BibleExperience\Presenters\Contracts\PresentableInterface;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use Str, Cache;

class Course extends BaseModel implements PresentableInterface {

	protected $table = 'courses';
	public $fillable = array('bible_verse_id','library_id','title','description','user_id','public','image','created_at','updated_at');
	protected $appends = array('defaultImage','lessonsCount');

	protected $presenter = 'BibleExperience\Presenters\Course';

	use PresentableTrait, ShortableTrait, GlobalIdTrait;

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

  public function owner()
  {
  	return $this->belongsTo('BibleExperience\User','user_id');
  }

		public function getLessonsCountAttribute()
  {
  	return $this->lessons->count();
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

 function getLessons($args, $random = false){

  switch($this->getCase($args,$random)){

    case 'filter':
      $collection = $this->lessons()->search($args['filter'])->get();
      break;

    case 'find':
      $decoded = $this->decodeGlobalId($args['id']);

      if(is_array($decoded) && count($decoded) > 1){
        $collection = $this->lessons()->where('lessons.id',$decoded['id'])->get();
      }else{
        $collection = $this->lessons()->where('lessons.id',$args['id'])->get();
      }

      break;

    case 'random':
    $collection = $this->lessons;
      break;

    case 'all':
    $collection = $this->lessons;
      break;
  }

  return $collection;
  }

  function getCase($args, $random){

    if(isset($args['filter'])){
  	  $case = 'filter';
  	}else if(isset($args['id'])){
  	  $case = 'find';
  	}else if($random == true){
  	  $case = 'random';
  	}else{
  	  $case = 'all';
  	}

  	return $case;
    }

}
