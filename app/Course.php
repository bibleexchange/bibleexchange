<?php namespace BibleExperience;

use Illuminate\Support\Facades\URL;
use BibleExperience\Core\PresentableTrait;
use BibleExperience\Core\ShortableTrait;
use BibleExperience\Presenters\Contracts\PresentableInterface;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Build\Course AS BuildCourse;
use Str, Cache, stdclass;
use BibleExperience\Textbook;

class Course extends BaseModel implements PresentableInterface {

	protected $table = 'courses';
	public $fillable = array('bible_verse_id','library_id','title','description','user_id','public','image','created_at','updated_at');

	protected $appends = array('defaultImage','lessonsCount','textbook','textbookSwahili');

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

	public function textbooks()
	{
		return $this->hasMany('\BibleExperience\Textbook');
	}

  public function activities() {
    return $this->hasManyThrough('\BibleExperience\Activity','\BibleExperience\Lesson');
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

  public function buildActivities()
  {
  	$file_name = base_path() . "/../courses/" . str_slug($this->title) . '/activities.json';
  	$conf = json_decode(file_get_contents($file_name));

  	foreach($conf->data AS $activity){
  		$a = new Activity;
  		$a->lesson_id = $activity->lesson_id;
  		$a->order_by = $activity->order_by;
  		$a->config = "{ \"template\":\"" . $activity->template . "\", \"data\":\"" . $activity->data . "\"}";
  		$a->save();
  	}


  }

	public function getDefaultImageAttribute()
	{
		if($this->image === null){
			$file_name = base_path() . "/../public_html/assets/img/tiles/" . str_slug($this->title) . '.jpg';

			if(file_exists($file_name)){
					return Url::to("/assets/img/tiles/" . str_slug($this->title) . '.jpg');
			}else{
					return Url::to("/assets/img/be_logo.png");
			}



		}else{
			return Url::to($this->image);
		}
	}

public function getLessonsCountAttribute()
  {
  	return $this->lessons->count();
  }

<<<<<<< HEAD
  public function getTextbookAttribute()
  {
  	$t = $this->textbooks()->where('lang','ENGLISH')->get()->last();

  	if($t !== null){
  		return $t->html;
  	}else{
=======
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
									$course->sections[$secCntr]->steps[$stepCntr]->media[$mediaCntr]->html = $course->getMediaHTMLString($media->type, $media->id);
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

					if(file_exists($directory . "/meta.json")){

						$course_meta = file_get_contents($directory . "/meta.json");

					}else{
						$course_meta = '{
							"title": "'.$this->title.'",
							"name": "'.$course_slug.'",
							"description": "",
						  "image":"",
							"keywords": [],
							"author": "'.$this->owner->name.'",
						  "sections":[]
						}';

					}

					$course = new BuildCourse($course_meta);
					$ignore = ["meta.json","be-notebook.json"];
					$sections = scandir($directory);

					$secCntr = 0;
					foreach($sections AS $sec){

					if(strpos($sec, '.') !== (int) 0 && ! in_array($sec, $ignore)) {

								$stepCntr = 0;
								$s = new stdclass;
								$s->id =  $secCntr+1;

								if(is_dir($directory . "/" . $sec)){
									$steps = scandir($directory . "/" . $sec);
								}else{
									$steps = [];
								}

								if(in_array("meta.json",$steps)){
									$s = json_decode(file_get_contents($directory . "/" . $sec . "/meta.json"));
									$s->steps = [];
								}else{

									$x = explode("_",$sec);

									if(isset($x[1])){
									 $s->title = ucwords(str_replace('-',' ', $x[1]));
									 $s->steps = [];
								 }else{
									 $s->title = null;
									 $s->steps = [];
								 }

								}

								foreach($steps AS $step){
								if(strpos($step, '.') !== (int) 0 && $step !== "meta.json") {

									$lesson = new stdclass;
									$x = explode("_",$step);
									$lesson_dir = $directory . "/" . $sec . "/" . $step;

									if(is_dir($lesson_dir)){
										$medias = scandir($directory . "/" . $sec . "/" . $step);
									}else{
										$medias = ["lesson_as_file"];
									}

									if(in_array("meta.json",$medias)){
										$lesson = json_decode(file_get_contents($directory . "/" . $sec . "/" . $step . "/meta.json"));
									}else if(isset($x[1])){
										$x[1] = str_replace(['.md','.html','.json'],'',$x[1]);
										$lesson->title = ucwords(str_replace("-"," ",$x[1]));
									}else{
										$lesson->title = null;
									}

									if(! isset($lesson->media) || $lesson->media === null){$lesson->media = [];}

									$mediaCntr = 0;
									foreach($medias AS $media){
									if(strpos($media, '.') !== (int) 0 && $media !== "meta.json") {

										if($media === "lesson_as_file"){
											$file_parts = pathinfo($step);
											$id_specific = $course_slug . "/" . $sec . "/" . $step;
											$media = $step;
										}else{
											$file_parts = pathinfo($media);
											$id_specific = $course_slug . "/" . $sec . "/" . $step . "/" . $media;
										}

										$m = new stdclass;
										$m->type = 'FILE';
										$m->id = "https://raw.githubusercontent.com/bibleexchange/courses/master/" . $id_specific;

										$m->parts = $course->getMediaHTMLString($m->type, $m->id);
										$m->trans = [];

										if($course->trans !== 'undefined' && isset($course->trans->$media)){

											foreach($course->trans->$media AS $lang){
>>>>>>> 4b3e293ce254361b723c99c117e2ddd864041317

  	return $this->buildTextbooks()->english;

  	}
  	
  }

   public function buildTextbooks()
  {
      $activities = $this->activities()->orderBy('lessons.order_by')->orderBy('activities.order_by')->get();

      $newT = new Textbook;
      $newT->course_id = $this->id;
      $newT->lang = 'ENGLISH';
      $newT->html = '';
      foreach($activities AS $a){
        $newT->html .= json_decode($a->body)->props;
      }
      
      $newT->save();

      $swa = new Textbook;
      $swa->course_id = $this->id;
      $swa->lang = 'SWAHILI';
      $swa->html = '';

      foreach($activities AS $a){
        $swa->html .= json_decode($a->swahiliBody)->props;
      }
      
      $swa->save();

      $textbooks = new stdClass;
      $textbooks->english = $newT->html;
      $textbooks->swahili = $swa->html;

      return $textbooks;
  }

    public function getTextbookSwahiliAttribute()
  {
  	   $t = $this->textbooks()->where('lang','SWAHILI')->get()->last();

      if($t !== null){
        return $t->html;
      }else{
        return $this->buildTextbooks()->swahili;
      }

  	}

  public static function updateFromArray(Array $array_of_props)
  {
      if(!isset($array_of_props['id'])){
          return response()->json(['error' => 'course_id_was_not_given', 'code'=>500, 'course'=> new Course]);
      }else{

		  $course = Course::find($array_of_props['id']);

		  $array_of_props = Self::getVerseFromReference($array_of_props);

		  unset($array_of_props['id']);

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


 public static function getVerseFromReference(Array $array_of_props)
  {
  	if(isset($array_of_props['reference'])){
	  
		if($array_of_props['reference'] === ""){
	  	}else{
	  		$verse = new BibleReference($array_of_props['reference']);
	  		if( $verse->start->verse !== null){
	  			$array_of_props['bible_verse_id'] = $verse->start->verse->id;
	  		}
	  		
	  	}

	  	unset($array_of_props['reference']);
		}
		return $array_of_props;

}

    public static function createFromArray(Array $array_of_props)
  {

		  $course = new Course;

		  if(!isset($array_of_props['library_id'])){
		  	$array_of_props['library_id'] = 5;
		  }
		  
		  $array_of_props = Self::getVerseFromReference($array_of_props);
		  
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
