<?php namespace BibleExperience\Entities;

use Str,stdClass;

class BibleChapter extends \Eloquent {
	
	//protected $connection = 'scripture';
	protected $table = 'biblechapters';
	protected $fillable = array('key_english_id','orderBy','summary');
	protected $appends = array('nextURL','previousURL','url','reference','nextReference','previousReference', 'previousChapter','nextChapter');
	
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

		$book = \BibleExperience\Entities\BibleBook::where('n','like',$search_book_title."%")->first();
		
		return $query->where('key_english_id',"{$book->id}")->where('orderBy', "{$chapter}");

	}
	
	public function verseByOrderBy($orderBy)
	{		
		return $this->hasMany('BibleExperience\Entities\BibleVerse')->where('v','=',$orderBy)->first();
	}	
	
	public function book()
	{
	    return $this->belongsTo('BibleExperience\Entities\BibleBook', 'key_english_id');
	}
	public function verses()
	{
	    return $this->hasMany('BibleExperience\Entities\BibleVerse');
	}
	
	public function notes()
	{
		return $this->hasManyThrough('BibleExperience\Entities\Note','BibleExperience\Entities\BibleVerse')->groupBy('notes.object_id');
	}

	public function studies()
	{
		return $this->hasManyThrough('BibleExperience\Entities\Study','BibleExperience\Entities\BibleVerse','bible_chapter_id','main_verse')->public()->orderBy('published_at','ASC');
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
	
	public function geturlAttribute()
	{
	    return '/bible/' . $this->book->slug . '/' . $this->orderBy;
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

	   return '/kjv/'.str_replace(' ','',strtolower($chapter->book->n)).'/'.$chapter->orderBy;
    }
	
	public function getnextURLAttribute()
    {
		
        if ($this->id == 1189){
    		$chapter = $this->find(1);
    	}else{
    		$chapter = $this->find($this->id+1);
    	}
	   
	   return '/kjv/'.str_replace(' ','',strtolower($chapter->book->n)).'/'.$chapter->orderBy;
    }
	
	public function getReferenceAttribute()
	{
	    return $this->book->n . ' ' . $this->orderBy;
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