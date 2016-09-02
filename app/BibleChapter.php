<?php namespace BibleExperience;

use Str,stdClass;

class BibleChapter extends \Eloquent {
	
	//protected $connection = 'scripture';
	protected $table = 'biblechapters';
	protected $fillable = array('bible_book_id','order_by','summary');
	protected $appends = array('nextURL','previousURL','url','reference','nextReference','previousReference', 'previousChapter','nextChapter','verseCount');
	
	public function scopeSearchReference($query, $reference)
	{				
		$r = explode(' ',$reference);

		$search_book_title = substr($r[0],0,4);
		$chapter = $r[1];
		
		if(is_numeric(substr($search_book_title,0,1))){
			if(count($r) === 3){
				$search_book_title = $r[0] . " " . $r[1];
				$chapter = $r[2];
			}else{
				$search_book_title = str_replace(substr($r[0],0,1), substr($r[0],0,1). " ", $r[0]);
				$chapter = $r[1];
			}
		}

		$book = \BibleExperience\BibleBook::where('n','like',$search_book_title."%")->first();
		
		return $query->where('key_english_id',"{$book->id}")->where('order_by', "{$chapter}");

	}
	
	public static function findByReference($reference)
	{				
		$r = explode('_',$reference);

		$search_book_title = substr($r[0],0,4);
		$chapter = $r[1];
		
		if(is_numeric(substr($search_book_title,0,1))){
			if(count($r) === 3){
				$search_book_title = $r[0] . " " . $r[1];
				$chapter = $r[2];
			}else{
				$search_book_title = str_replace(substr($r[0],0,1), substr($r[0],0,1). " ", $r[0]);
				$chapter = $r[1];
			}
		}

		$book = \BibleExperience\BibleBook::where('n','like',$search_book_title."%")->first();
		
		return $book->chapters()->where('order_by', "{$chapter}")->first();

	}
	
	public function verseByOrderBy($order_by)
	{		
		return $this->hasMany('BibleExperience\BibleVerse')->where('v','=',$order_by)->first();
	}	
	
	public function book()
	{
		return $this->belongsTo('\BibleExperience\BibleBook','bible_book_id');
	}
	
	public function verses()
	{
	    return $this->hasMany('BibleExperience\BibleVerse');
	}
	
	public function notes()
	{
		return $this->hasManyThrough('BibleExperience\Note','BibleExperience\BibleVerse')->orderBy('notes.bible_verse_id');
	}

	public function studies()
	{
		return $this->hasManyThrough('BibleExperience\Study','BibleExperience\BibleVerse','bible_chapter_id','main_verse')->public()->orderBy('published_at','ASC');
	}
	
	public function userNotes($user)
	{
		if($user === null){
			return [null];
		}
		
				$chapter_notes[] = array_where($verse->notes, function($key, $value)
				{
					$note;
				});		
		
		$chapter_notes = [null];

		$verses = $this->verses;	
		$authorsList = $user->followedUsers->lists('id');
		$authors = array_add($authorsList, null, $user->id);
		

		return $chapter_notes;
		
	}
	
	public function getUrlAttribute()
	{
		return '/bible/' . $this->book->slug . '_' . $this->order_by;
	}
	
	public function studyUrl($study)
	{
	    return '/study/' . $study->id . '-' . Str::slug($study->title) . '?bible=' .  $this->reference;
	}
	
	public function getPreviousURLAttribute()
    {	
		
    	if ($this->id == 1){
    		$chapter = $this->find(1189);
    	}else{
    		$chapter = $this->find($this->id-1);
    	}

	   return '/kjv/'.str_replace(' ','',strtolower($chapter->book->n)).'/'.$chapter->order_by;
    }
	
	public function getnextURLAttribute()
    {
		
        if ($this->id == 1189){
    		$chapter = $this->find(1);
    	}else{
    		$chapter = $this->find($this->id+1);
    	}

	   return '/kjv/' 
	   . str_replace(' ','',strtolower($chapter->book->n))
	   . '/'
	   . $chapter->order_by;
    }
	
	public function getReferenceAttribute()
	{
	    return $this->book->n . ' ' . $this->order_by;
	}
	
	public function getVerseCountAttribute()
	{
	    return $this->verses->count();
	}
	
	public function getNextReferenceAttribute()
    {
       if ($this->id == 1189){
			$chapter = $this->find(1);
		}else{
			$chapter = $this->find($this->id+1);
		}
	  
	  return $chapter->reference;
    }
	
	public function getPreviousReferenceAttribute()
    {	
		
		if ($this->id == 1){
			$chapter = $this->find(1189);
		}else{
			$chapter = $this->find($this->id-1);
		}
		
	   return $chapter->reference;
    }
	
	public function getNextChapterAttribute()
    {
       if ($this->id == 1189){
			$chapter = $this->find(1);
		}else{
			$chapter = $this->find($this->id+1);
		}
	
		$next = [$chapter->id,$chapter->url];
		 
	  return $next;
    }
	
	public function getPreviousChapterAttribute()
    {	
		
		if ($this->id == 1){
			$chapter = $this->find(1189);
		}else{
			$chapter = $this->find($this->id-1);
		}
		
	   $previous = [$chapter->id,$chapter->url];
		 
	  return $previous;
    }
}