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
    protected $fillable = ['body','bible_verse_id','type','user_id','tags_string','created_at','updated_at'];
    protected $appends = ['tags','author'];

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

    public static function search($search_term)
    {
    	$bible_verse = BibleVerse::isValidReference($search_term);
	

	if(is_object($bible_verse)){
	  return $bible_verse->notes;
	}else{
	  $notes = Note::where('body','like','%'.$search_term.'%')->orWhere('id',1)->get();

	  if($notes === null){
		return [];	
	  }else{
	  	return $notes;
	  }
	}

    }

    public function getTagsAttribute()
    {
	if($this->tags_string == ""){
	  return [];
	}else{
	  return explode(' ',$this->tags_string);
	}
	
    }

    public function getAuthorAttribute()
    {
    	return User::find($this->user_id);
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
  				$value = json_encode($value);
  				$api_request = 1;
  				break;
  			case "DC_RECORDING":
  				$type = $this->type;
				$value= [];

				$json = json_decode($this->body);

				if(isset($json->text)){
				  $value['text'] = $json->text;
				}

				if(isset($json->tags)){
				  $value['tags'] = $json->tags;
				}

				if(isset($json->links)){
				  $value['links'] = $json->links;
				}

				if(isset($json->soundcloudId)){
				  $value['soundcloudId'] = $json->soundcloudId;
				}

  				$value = json_encode($value);
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
