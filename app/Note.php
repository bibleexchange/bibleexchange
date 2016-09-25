<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;
use BibleExperience\User;
use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;
use BibleExperience\NoteCache;

function mynl2br($text) { 
   return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
} 

class Note extends \Eloquent {

	//protected $connection = 'mysql';

    use PresentableTrait, AmenableTrait, CommentableTrait;

    /**
     * Fillable fields for a new note.
     *
     * @var array
     */
    protected $fillable = ['body','bible_verse_id','type','user_id','created_at','updated_at'];
    protected $appends = ['tags','properties','author'];

    /**
     * Path to the presenter for a note.
     *
     * @var string
     */
    protected $presenter = 'BibleExperience\Presenters\NotePresenter';

	/**
     * Always capitalize the first name when we retrieve it
     */
    public function getDISABLEDBodyAttribute($value) {
        return JSON_DECODE($value);
    }

    public function getDates()
    {
        return ['created_at', 'updated_at', 'sent_at'];
    }

    public function withBody($body)
    {
    	$this->body = $body;

    	return $this;
    }

    public function isCreator($user){

    	if($this->author->id === $user->id){
    		return true;
    	}

    	return false;
    }

    public function verse()
    {
    	return $this->belongsTo('BibleExperience\BibleVerse','bible_verse_id');
    }

    public function url()
    {
    	return url('@' . $this->author->username . '/notes/' . $this->id);
    }

    public function editUrl()
    {
    	return null;
    }

    public function fbShareUrl()
    {
    	return url('@' . $this->author->username . '/notes/' . $this->id);
    }

    public function hint()
    {
    	return '"'.substr(strip_tags($this->body),0,64).'..." '.$this->verse->reference;
    }

    /**
     * Publish a new note.
     *
     * @param $body
     * @return static
     */
    public static function publish($bible_verse_id, $body, $image_id)
    {
    	$body = strip_tags($body);

        $note = new static(compact('bible_verse_id','body','image_id'));

        return $note;
    }

    public function image()
    {
    	return $this->belongsTo('BibleExperience\Image');
    }

    public function defaultImageUrl()
    {

    	if($this->image === null){

    		return 'http://bible.exchange/images/be_logo.png';
    	}

    	return url($this->image->src);

    }

    public function getTagsAttribute()
    {
		if(isset($this->body->tags)){
			$array = explode('#',$this->body->tags);
			unset($array[0]);
			$tags = implode(',',$array);
		}else {
			$tags = [];
		}

    	return $tags;
    }

    public function getPropertiesAttribute()
    {
    	$props = json_decode($this->body);
	    $props->tags = array_filter(explode("#",$props->tags));
	    return $props;
    }

    public function getAuthorAttribute()
    {
    	return User::find($this->user_id);
    }


    public function attachments(){
	return $this->hasMany('BibleExperience\StepAttachment');
    }

    public function cache(){
	return $this->hasMany('BibleExperience\NoteCache');
    }

	public function getOutputAttribute(){

	  if($this->cache->first() !== null){
		    $cache = $this->cache->last();
	  }else {
      $api_request = 0;

  		switch($this->type){
  			case "BIBLE_VERSE":
  				$type = $this->type;
  				$verse_id = (int) json_decode($this->body)->verse_id;
  				$verse = \BibleExperience\BibleVerse::find($verse_id);
  				$value = $verse->attributes;
  				$value['reference'] = $verse->reference;
  				$value = $value;
  				$api_request = 1;
  				break;
  			case "STRING":
  				$type = $this->type;
  				$value = $this->body;
          			$api_request = 1;
  				break;
  			case "JSON":
  				$type = $this->type;
  				$value = $this->body;
          			$api_request = 1;
  				break;
  			case "GITHUB":
  				$url = json_decode($this->body)->raw_url;
  				$value = $this->getRawFromUrl($url);

  				if($value[0] === "SUCCESS"){
  				    $type = "MARKDOWN";
				    $api_request = 1;
				    $value = trim($value[1]);
  				}else{
  				  $type = "GITHUB";
           			  $api_request = 0;
  				  $value = $url;
  				}

  				break;

  			default:
  				$type = $this->type;
  				$value = json_encode($this->attributes);
  		}

		$cache = new NoteCache;
    		$cache->type = $type;
		$cache->body = $value;
    		$cache->api_request = $api_request;
		$cache->note_id = $this->id;
		$cache->save();

		}

		return $cache;
	}

	public function lesson()
	{
	    return $this->belongsTo('BibleExperience\Lesson');
	}


	public function getRawFromUrl($url)
	{
	  $string = @file_get_contents($url);

		if(!$string){
		  return ['FAIL',$url];
		}else{
		  return ['SUCCESS',$string];
		}

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
