<?php namespace BibleExperience;

use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;

class Step extends \Eloquent  {

	protected $table = 'steps';
	public $fillable = array('body','course_id','order_by','created_at','updated_at');
	protected $appends = ['html','nextStep','previousStep','url'];

	public function course()
	{
	    return $this->belongsTo('BibleExperience\Course');
	}	

	public function getHtmlAttribute()
	{
	  $baseUrl = '/course/'.$this->course->id.'/'.$this->order_by;

	  $body = json_decode($this->body);
dd($this->body);
	  if($body === null){
		$string = Markdown::convertToHtml($this->body);
	  }else{
	  	$body = $body->items;
		  $string = '';

		  if (is_array($body)){
			foreach($body AS $el){
			 $string .= $this->outputString($el, $baseUrl);
			}
		
		  }else if(is_object($body)){
		    $string .= $this->outputString($body, $baseUrl);
		  }else if(is_string($body)){
		    $string .= $this->outputString($body, $baseUrl);
		  }
 	  }
	  return $string;
	}	

	public function outputString($obj, $baseUrl='')
	{

	  switch ($obj->type) {
	    case "file":

		$string = file_get_contents(storage_path().'/courses/'.$obj->value);
		
		if(strpos($obj->value,'.md') !== false){
		  $string = Markdown::convertToHtml($string);		
		}

		break;
	    case "download/markdown":
		$string = file_get_contents($obj->value);
		$string = Markdown::convertToHtml($string);
		break;
	    case "verses":
		$list = explode(' ',$obj->value);
		$verses = BibleVerse::searchForVerses($list);
		$string = '';

		foreach($verses AS $v){
		  $string .= $v->quoteRelative($baseUrl);
		};

		break;
	
	    default:
		$string = Markdown::convertToHtml($string);

	  }
	return $string;
	
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

}
