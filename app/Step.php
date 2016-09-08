<?php namespace BibleExperience;

use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;

class Step extends \Eloquent  {

	protected $table = 'steps';
	public $fillable = array('body','course_id','order_by','created_at','updated_at');
	protected $appends = ['html','nextStep','previousStep','url'];

	public static function make( $course_id, $order_by)
	{
		$step = new static(compact('course_id', 'order_by'));
	
		return $step;
	}

    public function attachment(){
	return $this->hasMany('BibleExperience\StepAttachment');
    }

	public function course()
	{
	    return $this->belongsTo('BibleExperience\Course');
	}	

	public function getHtmlAttribute()
	{

	  $baseUrl = '/course/'.$this->course->id.'/'.$this->order_by;

	  $body = json_decode($this->body);

	  if($body === null){
		$this->body = Markdown::convertToHtml($this->body);
	  }else{

		  if (is_array($body->items)){
			$x = 0;
			foreach($body->items AS $el){
			 $body->items[$x] = $this->outputString($el, $baseUrl);
			}
		
		  }else if(is_object($body->items)){
		    $body->items = $this->outputString($body->items, $baseUrl);
		  }else if(is_string($body->items)){
		     $body->items = $this->outputString($body, $baseUrl);
		  }
 	  }


	//$this->cached = $string;
	//$this->save();		

	  return $body;



	//return $this->cached;
	}	

	public function outputString($obj, $baseUrl='')
	{
	  $newObj = new \stdClass();

	  switch ($obj->type) {
	    case "file":
		$newObj->type = "file";
		$newObj->value = $obj->value;
		//$string = file_get_contents(storage_path().'/courses/'.$obj->value);
		/*
		if(strpos($obj->value,'.md') !== false){
		  $string = Markdown::convertToHtml($string);		
		}
		*/
		break;
	    case "download/markdown":
		
		$newObj->type = "download/markdown";
		$newObj->value = $obj->value;
		//$string = file_get_contents($obj->value);
		//$objstring = Markdown::convertToHtml($string);
		break;
	    case "verses":
		$list = explode(' ',$obj->value);
		$verses = BibleVerse::searchForVerses($list);
		$string = '';
		$newObj = [];
		
		foreach($verses AS $v){
		  $newObj[] = $v;
		};

		break;
	
	    case "quiz":
		$newObj = $this->transformQuiz($obj->value, $baseUrl);
		break;

	    default:
		$newObj = Markdown::convertToHtml(json_encode($obj->value));

	  }
	return $newObj;
	
	}

	public function getNextStepAttribute()
	{
	  if($this->order_by < $this->course->stepsCount){return Step::find($this->order_by+1);}else{return $this->course->steps()->where('order_by',1)->first();}
	}

	public function getPreviousStepAttribute()
	{
	  if($this->order_by !== 1){return Step::find($this->order_by-1);}else{return $this->course->steps()->where('order_by',1)->first();}
	}

	public function getUrlAttribute()
	{
	  return "/course/".$this->course->id."/".$this->order_by;
	}

	public function transformQuiz($el, $baseRef)
	{
	  $newObj = $el;
	  $x = 0;

	  foreach($el->questions AS $q){
	
		switch($q->type){
		  case 'bible/chapters':
			foreach($q->value AS $ch){
			  foreach(\BibleExperience\BibleChapter::find((int)$ch)->verses AS $v){
				$verses[] = $v->quoteRelative($baseRef);
			  }			
			}
			$newObj->questions[$x] = $verses;
			break;
		  case 'bible/memorize/verses':

			break;
		  case 'read/bible/verses':
		  	foreach($q->options AS $v){
				$verse = \BibleExperience\BibleVerse::find((int)$v);
				$verses[] = $verse;
			  }	
			$questions = $verses;
			break;
		
		}
		$x++;
	  }

		return $newObj;
	}

}
