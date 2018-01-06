<?php namespace BibleExperience;

use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\AmenableTrait;
use BibleExperience\Core\CommentableTrait;
use GrahamCampbell\Markdown\Facades\Markdown;
use BibleExperience\BibleVerse;
use BibleExperience\Note;
use BibleExperience\NoteCache;
use Symfony\Component\Debug\Exception;
use BibleExperience\Services\CourseCreator;

use stdClass;

class Note extends BaseModel {

    use PresentableTrait, AmenableTrait, CommentableTrait;

    protected $fillable = ['body','bible_verse_id','user_id','tags_string','created_at','updated_at','title'];
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

    public function getMedia(){
      
      return CourseCreator::getDefinitionsBody($this->body);
    }

    public function getOutputAttribute(){

	  //if($this->cache->first() !== null){
		//    $cache = $this->cache->last();
	  //}else {
      $cache = new NoteCache;
      $cache->body = $this->getMedia();
      $cache->note_id = $this->id;
      $cache->save();

	//	}

		return $cache;
	}

  public static function createFromRelay($input, $user)
    {

            $note = new stdClass;
            $note->error = new stdClass;
            $note->error->code = 200;
            $note->error->message = null;
	          $note->note = new Note;

    unset($input['clientMutationId'], $input['token']);
    
    foreach($input AS $key => $value){

      if($key === "reference"){
        $verse = BibleVerse::findByReference($value);
        $note->note->bible_verse_id = $verse? $verse->id:null;
      }else{
        $note->note->$key = $value;
      }
      
    }
	  
	  $note->note->user_id = $user->id;


	  try {
		  $note->note->save();
	  }catch(Exception $e){

        $note->error->message = $e->getMessage();
        $note->error->code = $e->getCode();
		    
        return $note;
	  };


    return $note;

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
 

}