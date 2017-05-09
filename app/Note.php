<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;
use BibleExperience\Note;
use BibleExperience\NoteCache;
use Symfony\Component\Debug\Exception;

use stdClass;

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
      if($type === "" || $type === null){
        $type = 'https://definitions.bible.exchange/default';
      }

      if(substr($type, 0,4) === 'http') {

          if(is_string($body) && $type !== "https://definitions.bible.exchange/default"){$body = json_decode($body);}
         

          $parser = self:: urlParser($type, $body);
          $type = $parser->type;
          $body = $parser->body;
      }

      switch($type){

        case "BIBLE_VERSE":
          $body = json_decode($body);
          $verse_id = (int) $body->verse_id;
          $verse = \BibleExperience\BibleVerse::find($verse_id);
          if($verse === null){
            $value = new stdClass();
          }else{
            $value = $verse->attributes;
            $value['reference'] = $verse->reference;
          }


          break;

       case "DC_RECORDING":
          $type = $type;
          $value= [];
            if(is_string($body)){
               $json = json_decode($body);
            }else {
               $json = $body;
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
        
        case "SOUNDCLOUD":
          $value = $body;
          $api_request = 1;
          break;

        case "STRING":
          $value = $body;
          $api_request = 1;
          break;

        case "JSON":
          if(is_string($body)){$body = json_decode($body); }
          if($body !== null){
            $value = json_encode($this->getOutputArray($body));
          }else{
            $value = null;
          }
          
          $api_request = true;
          break;
        case "json":
          $value = $this->getOutputArray($body);
          $api_request = true;
          break;

        case "FILE":
          $type = $type;
          $value = json_encode($this->getOutputArray(file_get_contents(base_path() . '/../courses/' . $body)));
          $api_request = 1;
          break;

          case "LOCAL_FILE":
            $type = "MARKDOWN";
            $value = @file_get_contents(base_path() . '/../courses/' . $body);


            if($value === false){
              $value = "Error, could not find LOCAL_FILE! " . $body;
            }else{
              $value = json_encode($value);
            }

            $api_request = 1;
            break;

        case "GITHUB":
          if(is_string($body)){
            $url = json_decode($body)->raw_url;
          }else{
            $url = $body->raw_url;
          }
          
          //$value = self::getRawFromUrl($url); //disabling get from github for now

          if(false/*$value[0] === "SUCCESS"*/){
              $type = "MARKDOWN";
            $api_request = 1;
            $value = trim($value[1]);
          }else{
            $value = @file_get_contents(
                base_path() . '/../courses/' . str_replace("https://raw.githubusercontent.com/bibleexchange/courses/master/","",$url)
                );

            if($value === false){
              $value = "Error, could not find GITHUB! " . $url;
            }
            $type = "MARKDOWN";
            $api_request = 0;
          }

          break;

        default:
          $value = $body;
          $api_request = true;
      }

      $x = new \stdclass();
      $x->type = $type;
      $x->value = $value;
      $x->api_request = $api_request;

      return $x;
    }

    public function getOutputArray($body){

        $att = $body;
        $x = clone $att;

      $x->media = [];
      foreach($att->media AS $m){

        if(is_string($m)){
          $y = explode("|",$m);
          $type = $y[0];
          if(isset($y[1])){$body = json_decode($y[1]);}else{$body = null;}
        }else{

          if(isset($m->body)){
            $type = $m->type;
            $body = $m->body;
          }else{

            $type = $m->type;
            $body = $m;
          }

        }

        $x->media[] = $this->getMedia($type, $body);
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

      if($x->type === "STRING"){
        $cache->body = $x->value;
      }else{
         $cache->body = json_encode($x->value);
      }
      
      $cache->api_request = $x->api_request;
      $cache->note_id = $this->id;
      $cache->save();

	//	}

		return $cache;
	}

	public static function getRawFromUrl($url)
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
    unset($input['clientMutationId'],$input['id'], $input['token']);
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

     public static function createFromBody($input, $user)
    {

    $note = new Note;

    $note = self::addPropsFromBody($note, $input['body']);
    
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

public static function addPropsFromBody($note, $body){

  $note->body = $body;
  $note->type = '';

      preg_match("/@@([^@]*)@@/m", $body, $meta);

      $meta = str_replace("@@","",$meta[0]);
      $meta = explode(PHP_EOL,$meta);

    foreach($meta AS $m){

      $m = explode(':',$m, 2);

      if(isset($m[0]) && isset($m[1])){

          $key = trim($m[0]);
          $value = trim($m[1]);

          if($key === "reference"){

            $ref = new BibleReference($value);
            if($ref->start->verse !== null){
              $note->bible_verse_id = $ref->start->verse->id;
            }else{
              $note->bible_verse_id = $ref->start->chapter->verses->first()->id;
            }
            
          } else if($key === "tags"){
            $note->tags_string = $value;
          } else if($key === "tags_string"){
            $note->tags_string = $value;
          }else if($key == "title"){
            $note->title = $value;
          }
      }
    }

  return $note;
}

    public static function updateFromBody($props, $user)
    {

        if(!isset($props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'note'=> new Note]);
        }else{

    $note = Note::find($props['id']);

      if($user->id !== $note->author->id){
        return ['error' => 'You cannot edit this Note', 'code'=>402, 'note'=> $note];
        }

    $note = self::addPropsFromBody($note, $props['body']);

    try {
      $note->save();
    }catch(Exception $e){
    return response()->json(['error' => $e->getMessage(), 'code'=>$e->getCode(), 'note'=> new Note]);
    };

    $note->cache()->delete();

    return ['error' => null, 'code'=>200, 'note'=> $note];

  }
}

    public static function updateFromArray(Array $array_of_props, $user)
    {

        if(!isset($array_of_props['id'])){
            return response()->json(['error' => 'id_was_not_given', 'code'=>500, 'note'=> new Note]);
        }else{

	  $note = Note::find($array_of_props['id']);

	  unset($array_of_props['clientMutationId'], $array_of_props['token'], $array_of_props['id']);

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

  public function getMeta($meta)
  { 

    $meta->title = 'Discover this: ' . $this->title . ' noted on Bible Exchange';
      $meta->keywords = $this->tags_string;
      $meta->author = $this->author->name;
      $meta->description = $this->author->name . ' noted this on Bible.exchange. View this and more on Bible.exchange.';//No more than 155 characters
      $meta->shareImage = 'https://bible.exchange/images/be_logo.png';//Twitter summary card with large image must be at least 280x150px
      $meta->articlePublished = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
      $meta->articleModified = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
      $meta->articleSection = $meta->url;

   return $meta;


}

  public static function urlParser($url, $instructions = null)
  { 

    $FAKED = '{
       "kind": "youtube#searchListResponse",
       "etag": "\"m2yskBQFythfE4irbTIeOgYYfBU/AYkvewqHZhv13TWdGFga-ZNu980\"",
       "nextPageToken": "CAEQAA",
       "regionCode": "US",
       "pageInfo": {
        "totalResults": 8,
        "resultsPerPage": 1
       },
       "items": [
        {
         "kind": "youtube#searchResult",
         "etag": "\"m2yskBQFythfE4irbTIeOgYYfBU/2FSHlWlpQqNddGlemHBv-QpXK8Q\"",
         "id": {
          "kind": "youtube#video",
          "videoId": "2n7UgwWGUeQ"
         },
         "snippet": {
          "publishedAt": "2015-07-17T21:41:41.000Z",
          "channelId": "UCRL3LmQvt3G0d5UFnLPUKNA",
          "title": "DAFFY DUCK Looney Tunes Cartoons Compilation ► Best Of Looney Toons Cartoons For Kids [HD 1080]",
          "description": "This compilation includes some of the all-time best classic Daffy Duck Cartoons. All episodes have been remastered in HD 1080, the episode times and details ...",
          "thumbnails": {
           "default": {
            "url": "https://i.ytimg.com/vi/2n7UgwWGUeQ/default.jpg",
            "width": 120,
            "height": 90
           },
           "medium": {
            "url": "https://i.ytimg.com/vi/2n7UgwWGUeQ/mqdefault.jpg",
            "width": 320,
            "height": 180
           },
           "high": {
            "url": "https://i.ytimg.com/vi/2n7UgwWGUeQ/hqdefault.jpg",
            "width": 480,
            "height": 360
           }
          },
          "channelTitle": "8thManDVD.com™ Cartoon Channel",
          "liveBroadcastContent": "none"
         }
        }
       ]
      }';

//
    $parser = new stdClass;
    $parser->type = 'STRING';
    $parser->instructions = new stdClass;
    $parser->api_request = new stdClass;

    if($instructions === null || $instructions === ""){
      $parser->instructions->value = new stdClass;
      $parser->instructions->api = false;
    }else{
      $parser->instructions->value = $instructions;

      if(!isset($parser->instructions->api)){

        $parser->instructions->api = false;
      }
    }

    $parser->url = $url;

    preg_match('/^(https?:\/\/)?(ftp:\/\/)??(file:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,8})?/', $url, $domain);

    $x = explode('://',$domain[0]);

    $parser->protocol = $x[0];
    $parser->domain = $x[1];
    $parser->id = str_replace($domain[0] . '/', "", $url);

    switch($parser->domain){

      case 'definitions.bible.exchange':

          $d = self::getDefinitionsBody($parser->id, $parser->instructions->value);
          $parser->body = $d->body;
          $parser->type = $d->type;
          $parser->api_request->code = 200;
          $parser->api_request->message = '';

      break;

      case 'bible.exchange':

          $be = self::getBibleExchangeBody($parser->id, $parser->instructions->value);
          $parser->body = $be->body;
          $parser->type = $be->type;
          $parser->html = $be->html;
          $parser->api_request->code = 200;
          $parser->api_request->message = '';

      break;

      case 'raw.githubusercontent.com':

            $response = self::getRawFromUrl($url);

            if($response[0] === "SUCCESS"){
               
               $parser->body = $response[1];
               $parser->html = Markdown::convertToHtml($response[1]);
               $parser->api_request->code = 200;
               $parser->api_request->message = $response[0];
             }else{

              $parser->body = null;
              $parser->api_request->code = 400;
              $parser->api_request->message = $response[0];
              $parser->html = null;

             }

      break;

      case 'youtube.com':
      case 'www.youtube.com':
        $parser->id = str_replace("watch?v=","",$parser->id);
      case 'youtu.be':



        $parser->type = 'YOUTUBE_API';
        $youtube_api_key = env('YOUTUBE_API_KEY');
        $youtube_api_url = "https://content.googleapis.com/youtube/v3/search?maxResults=1&part=snippet&q=".$parser->id."&type=video&key=" . $youtube_api_key;
        
        $parser->html =  '<iframe width="100%" style="min-height:250px;" src="https://www.youtube.com/embed/'.$parser->id.'" frameborder="0" allowfullscreen></iframe>';
        $parser->body = json_decode($FAKED); //self::getRawFromUrl($youtube_api_url);  
        $parser->api_request->code = 200;
        $parser->api_request->message = "Success";

      break;

      case 'feeds-tmp.soundcloud.com':
      case 'api.soundcloud.com':
     
        $parser->type = 'STRING';    

        $id =  explode('/',$parser->id);

        if($id[0] === "tracks" || $id[0] === "stream"){
          $parser->html =  '<iframe width="100%" height="200" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$id[1].'&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
        }else{
          $parser->html =  $parser->id;
        }

        $parser->body = json_decode('{}'); 
        $parser->api_request->code = 200;
        $parser->api_request->message = "Success";

      break;

      

      default:

        $parser->body = $instructions;
        $parser->html = "<a href='" . $parser->url . "'>".$parser->url."</a>";
        $parser->api_request->code = 201;
        $parser->api_request->message = "Success";
      }

    return $parser;

  }

    public static function getBibleExchangeBody($id, $instructions = null)
  { 

    $be = new stdClass;
    $be->type = null;
    $be->body = new stdClass;

    $id_array = explode('/',$id);


    switch($id_array[0]){

      case 'bible':
        $be->type = "BIBLE_REFERENCE";
        $ref_object = new BibleReference($id_array[1]);
        $ref_object->reference = $ref_object->input->string;
        $ref_object->verses = [];
        $html = '';

          foreach($ref_object->versesInRange() AS $v){

            $verse = new stdClass;
            $verse->id = $v->id;
            $verse->order_by= $v->order_by;
            $verse->body = $v->body;
            $verse->url =  $v->url;
            $verse->reference =  $v->reference;

            $ref_object->verses[] = $verse;
            $html .= $v->quote;
          }

          $be->body = $ref_object; 
          $be->html = $html;

      break;

      case 'notes':    
        $be->type = "NOTE";
        $id = explode(":",base64_decode($id_array[1]))[1];
        $note = Note::find($id);
        $be->body = $note;
        $be->html = null;

      break;

      case 'courses':
        $be->type = "Course";
        $be->body = Course::find($id);
        $be->html = null;
      break;


      default:
        $be->type = null;
        $be->body = new stdClass;
      }
    
    return $be;

  }

  public static function getDefinitionsBody($id, $instructions = null)
  { 

    $obj = new stdClass;
    $obj->type = null;
    $obj->body = new stdClass;

    switch($id){

      case 'json':
        $obj->type = "JSON";
        $obj->body = $instructions;

      break;

      default:
        $obj->type = "STRING";

        $instructions = preg_replace("/@@[^@]*@@/m", "", $instructions);

       $pattern = "/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,8}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/";


      $NewText = preg_replace_callback("/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,8}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)/", function($Match){

          $url = explode('|',$Match[0]);

          $x = null;

          if(isset($url[1])){
            $x = self::urlParser($url[0],json_decode($url[1]))->html;
          }else{
            $x = self::urlParser($url[0],null)->html;
          }
         
            return $x;

    }, $instructions);

        $obj->body = Markdown::convertToHtml($NewText);
      }
    
    return $obj;

  }

}