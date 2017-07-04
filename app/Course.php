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

										if(array_key_exists("extension",$file_parts) === false){
											$type = "RAW_FROM_URL";
										}else if($file_parts['extension'] === "json"){
											$type = "JSON";
										}else{
											$type =  "RAW_FROM_URL";
										}

										$m = new stdclass;
										$m->type = $type;
										$m->id = "https://raw.githubusercontent.com/bibleexchange/courses/master/" . $id_specific;

										$m->html = utf8_encode( $course->getMediaHTMLString($m->type, $m->id) );
										$m->trans = [];

										if($course->trans !== 'undefined' && isset($course->trans->$media)){

											foreach($course->trans->$media AS $lang){

												$m->trans[$lang->lang] = $course->getMediaHTMLString("TRANSLATION", "https://raw.githubusercontent.com/bibleexchange/courses/master/translations/" . $course_slug . "/" . $lang->lang . "/" . $lang->file );
											}

										}else{
											$m->trans = false;
										}

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
					return json_encode(new BuildCourse('{"title":"Cannot find media! Not located where expected. I looked in '.$directory.'"}'));
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

		public static function search($search_term)
		{

			if($search_term == ""){
				return Course::where('public',1)->get();
			}else {

					$term = str_replace('%20',' ', $search_term);
					$term = str_replace(" ","+",$term);
					$terms = explode("+", $term);

					$searchThese = [];

					foreach($terms AS $t){
						$searchThese[] = ['title','like','%'.$t.'%'];
					}

					$courses = Course::where($searchThese)->get();

					if($courses !== null){
						$c = [];
						foreach($courses AS $course){
							if($course->public === 1){
								$c[] =  $course;
							}
						}

						return collect($c);
					}else{
						return collect([]);
					}
				}


			}

}
