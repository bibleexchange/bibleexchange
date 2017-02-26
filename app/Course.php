<?php namespace BibleExperience;

use Illuminate\Support\Facades\URL;
use BibleExperience\Core\PresentableTrait;
use BibleExperience\Core\ShortableTrait;
use BibleExperience\Presenters\Contracts\PresentableInterface;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Build\Course AS BuildCourse;
use Str, Cache, stdclass;

class Course extends BaseModel implements PresentableInterface {

	protected $table = 'courses';
	public $fillable = array('bible_verse_id','library_id','title','description','user_id','public','image','created_at','updated_at');
	protected $appends = array('defaultImage','lessonsCount','everything');

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

	public function getEverythingAttribute()
	{
		$data_file = resource_path() . '/courses/'. str_slug($this->title) . '.json';

		if(file_exists($data_file)){

			$file = file_get_contents($data_file);

			$course = new BuildCourse($file);
			$sections = $course->sections;

				$secCntr = 0;
				foreach($sections AS $sec){
							$stepCntr = 0;
							foreach($sec->steps AS $step){
								$mediaCntr = 0;
								foreach($step->media AS $media){
									$course->sections[$secCntr]->steps[$stepCntr]->media[$mediaCntr]->html = utf8_encode( $course->getMediaHTMLString($media->type, $media->id) );
									$mediaCntr++;
								}
								$stepCntr++;
							}
							$secCntr++;
				}
				return json_encode($course);

		}else{
			$course_slug = str_slug($this->title);

			$directory = resource_path() . '/../../courses/'. $course_slug;

				if(file_exists($directory)){

					$course_meta = file_get_contents($directory . "/meta.json");
					$course = new BuildCourse($course_meta);

					$sections = scandir($directory);

					$secCntr = 0;
					foreach($sections AS $sec){

					if(strpos($sec, '.') !== (int) 0 && $sec !== "meta.json") {
								$stepCntr = 0;
								$s = new stdclass;
								$s->id =  $secCntr+1;


								$steps = scandir($directory . "/" . $sec);

								if(in_array("meta.json",$steps)){
									$s = json_decode(file_get_contents($directory . "/" . $sec . "/meta.json"));
									$s->steps = [];
								}else if(isset($x[1])){
									$s->title = explode("_",$sec)[1];
									$s->steps = [];
								}else{
									$s->title = null;
									$s->steps = [];
								}

								foreach($steps AS $step){
								if(strpos($step, '.') !== (int) 0 && $step !== "meta.json") {

									$lesson = new stdclass;
									$x = explode("_",$step);

									$medias = scandir($directory . "/" . $sec . "/" . $step);

									if(in_array("meta.json",$medias)){
										$lesson = json_decode(file_get_contents($directory . "/" . $sec . "/" . $step . "/meta.json"));
									}else if(isset($x[1])){
										$lesson->title = $x[1];
									}else{
										$lesson->title = null;
									}

									if(! isset($lesson->media) || $lesson->media === null){$lesson->media = [];}

									$mediaCntr = 0;
									foreach($medias AS $media){
									if(strpos($media, '.') !== (int) 0 && $media !== "meta.json") {

										$m = new stdclass;
										$m->type = "RAW_FROM_URL";
										$m->id = "https://raw.githubusercontent.com/bibleexchange/courses/master/" . $course_slug . "/" . $sec . "/" . $step . "/" . $media;
										$m->html = utf8_encode( $course->getMediaHTMLString($m->type, $m->id) );

										array_push($lesson->media, $m);
										$mediaCntr++;
									}
									}
									array_push($s->steps, $lesson);
									$stepCntr++;
								}
								}

								array_push($course->sections, $s);
								$secCntr++;
					}

					}
					return json_encode($course);





				}else{
					return null;
				}



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
