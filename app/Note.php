<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;
use BibleExperience\NoteCache;

class Note extends BaseModel {

    use PresentableTrait, AmenableTrait, CommentableTrait;

    protected $fillable = ['body','bible_verse_id','type','user_id','tags_string','created_at','updated_at','title'];
    protected $appends = ['tags','output'];
    protected $presenter = 'BibleExperience\Presenters\NotePresenter';

//RELATIONSHIPS & RELATIONSHIP FUNCTIONS

  public function author()
    {
    	return $this->belongsTo('BibleExperience\User','user_id');
  }

  public function isAuthor($user){

    	if($this->author->id === $user->id){
    		return true;
    	}

    	return false;
  }

  public function verse()
  {
    return $this->belongsTo('BibleExperience\BibleVerse','bible_verse_id');
  }

//END RELATIONSHIPS

    public static function search($search_term)
    {

	if($search_term == ""){
	  return Note::all();
	}else {
	    	$bible_verse = BibleVerse::getReferenceObject(str_replace("+"," ",$search_term));

		if($bible_verse->start->verse !== null && count($bible_verse->start->verse->notes) > 0){

		  return $bible_verse->start->verse->notes;

		}else if($bible_verse->start->chapter !== null && count($bible_verse->start->chapter->notes) > 0){
		  return $bible_verse->start->chapter->notes;
		}else if($bible_verse->start->book !== null && count($bible_verse->start->book->notes) > 0){
		  return $bible_verse->start->book->notes;
		}else{
		  $term = str_replace('%20',' ', $search_term);
		  $term = str_replace(" ","+",$term);
		  $terms = explode("+", $term);

		  $searchThese = [];

		  foreach($terms AS $t){
		    $searchThese[] = ['tags_string','like','%'.$t.'%'];
		  }
		  $notes = Note::where($searchThese)->get();

		  if($notes !== null){
			return $notes;
		  }else{
		    return collect([]);
		  }
		}


	}
    }

    public function getTagsAttribute()
    {
    	if($this->tags_string == ""){
    	  return [];
    	}else{
    	  return explode('#',$this->tags_string);
    	}

    }

    public function cache(){
	     return $this->hasMany('BibleExperience\NoteCache');
    }

    public function getMedia($type, $body){

      $api_request = 1;

      switch($type){
        case "BIBLE_VERSE":
          $verse_id = (int) $body->verse_id;
          $verse = \BibleExperience\BibleVerse::find($verse_id);
          $value = $verse->attributes;
          $value['reference'] = $verse->reference;

          break;
        case "DC_RECORDING":
          $type = $type;
          $value= [];
            if(is_object($body)){
              $json = $body;
            }else {
              $json = json_decode($body);
            }

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
          $value = $body;
          $api_request = 1;
          break;
        case "JSON":
          $value = $body;
          $api_request = 1;
          break;

        case "FILE":
          $type = $type;
          $value = json_encode($this->getOutputArray(file_get_contents(base_path() . '/../courses/' . $body)));
          $api_request = 1;
          break;

          case "LOCAL_FILE":
            $type = "MARKDOWN";
            $value = json_encode(file_get_contents(base_path() . '/../courses/' . $body));
            $api_request = 1;
            break;

        case "GITHUB":
          $url = json_decode($body)->raw_url;
          $value = $this->getRawFromUrl($url);

          if($value[0] === "SUCCESS"){
              $type = "MARKDOWN";
            $api_request = 1;
            $value = Self::findScriptureReferences(trim($value[1]));
          }else{
            $type = "GITHUB";
                  $api_request = 0;
            $value = $url;
          }

          break;

        default:
          $value = json_encode($body);
      }

      $x = new \stdclass();
      $x->type = $type;
      $x->value = $value;
      $x->api_request = $api_request;

      return $x;
    }

    public function getOutputArray($body){

      $att = json_decode($body);

      $x = clone $att;
      $x->media = [];
      foreach($att->media AS $m){
        $x->media[] = $this->getMedia($m->type, $m->body);
      }
      return $x;

  }

    public function getOutputAttribute(){

	  //if($this->cache->first() !== null){
		//    $cache = $this->cache->last();
	  //}else {
      $api_request = 0;
      $x = $this->getMedia($this->type, $this->body);

      $cache = new NoteCache;
      $cache->type = $x->type;
      $cache->body = $x->value;
      $cache->api_request = $x->api_request;
      $cache->note_id = $this->id;
      $cache->save();

	//	}

		return $cache;
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

  public static function createFromRelay($input, $user)
    {

	  $note = new Note;
    unset($input['clientMutationId'],$input['id']);
    foreach($input AS $key => $value){

      if($key === "reference"){
        $verse = BibleVerse::findByReference($value);
        $note->bible_verse_id = $verse? $verse->id:null;
      }else{
        $note->$key = $value;
      }
      
    }
	  
	  $note->user_id = $user->id;


	  try {
		  $note->save();
	  }catch(Exception $e){
		    return ['error' => $e->getMessage(), 'code'=>$e->getCode(), 'note'=> $note];
	  };


    return ['error' => null, 'code'=> 200, 'note'=> $note];

    }

  public static function destroyFromRelay($noteId)
    {
	$note = Note::find($noteId);

	  try {
		$note->delete();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'note'=> $note]);
	  };

	  return ['error' => null, 'code'=>200, 'note'=> $note];

    }

    public static function updateFromArray(Array $array_of_props, $user)
    {

        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'note'=> new Note]);
        }else{

	  $note = Note::find($array_of_props['id']);

	  unset($array_of_props['id']);
	  unset($array_of_props['clientMutationId']);

	  foreach($array_of_props AS $key => $value){
          if($key === "reference"){

            $note->bible_verse_id = BibleVerse::findByReference($value)->id;

          } else if($key !== "bible_verse_id"){
            $note->$key = $value;
          }

	  }

	  try {
		$note->save();
	  }catch(Exception $e){
		return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'note'=> new Note]);
	  };

	  $note->cache()->delete();

	  return ['error' => null, 'code'=>200, 'note'=> $note];

	}
}

	public static function findScripture($matches)
	{
	  return "<a href='/bible/".$matches[0]."'>" . $matches[0] . "</a>";
	}

	public static function findScriptureReferences($text){




		return preg_replace_callback(
		    "/(?:\d\s*)?[A-Z]?[a-z]+\s*\d+(?:[:-]\d+)?(?:\s*-\s*\d+)?(?::\d+|(?:\s*[A-Z]?[a-z]+\s*\d+:\d+))?/",
		    function($matches){
			return "<a href='/bible/".$matches[0]."'>" . $matches[0] . "</a>";
		    },
		    $text);
	}

}
