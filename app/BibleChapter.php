<?php namespace BibleExperience;

use Str,stdClass;

class BibleChapter extends \Eloquent {

	//protected $connection = 'scripture';
	protected $table = 'biblechapters';
	protected $fillable = array('bible_book_id','order_by','summary');
	protected $appends = array('url','reference','referenceSlug','previousChapter','nextChapter','verseCount', 'stepsCount');

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

		$book = \BibleExperience\BibleBook::where('title','like',$search_book_title."%")->first();

		return $query->where('key_english_id',"{$book->id}")->where('order_by', "{$chapter}");

	}

	public static function findByReference($reference)
	{

	  $r = str_replace(' ','_',$reference);

		if(is_numeric(substr($r,0,1)) && substr($r,1,2) == "_"){
			$r = preg_replace("~_~", " ", $r, 1);
		}else if(is_numeric(substr($r,0,1)) && substr($r,1,2) != " "){
			$r = substr($r,0,1) . " " . substr($r,1,20);
		}

	  $r = explode('_',$r);
		$search_book_title = $r[0];
		$chapter = $r[1];

	  If(!isset($r[0]) || !isset($r[1])){
			return new BibleChapter;
	  }else{
			$book = \BibleExperience\BibleBook::where('slug','like',$search_book_title."%")->first();
		if($book !== null){
		  $chapter = $book->chapters()->where('order_by', "{$chapter}")->first();
		  if($chapter !== null){return $chapter;}else{return new BibleChapter;}
		}
		return new BibleChapter;
	  }

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

	public function steps()
	{
	    return $this->hasMany('BibleExperience\BibleVerse');
	}

	public function notes()
	{
		return $this->hasManyThrough('BibleExperience\Note','BibleExperience\BibleVerse')->orderBy('notes.bible_verse_id');
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
	  if($this->book !== null){return '/bible/' . $this->book->slug . '_' . $this->order_by;}
	  return null;

	}

	public function studyUrl($study)
	{
	    return '/study/' . $study->id . '-' . Str::slug($study->title) . '?bible=' .  $this->reference;
	}

	public function getReferenceAttribute()
	{
	   if($this->book !== null) { return $this->book->title . ' ' . $this->order_by;}
	   return null;
	}

	public function getReferenceSlugAttribute()
	{
	    return strtolower($this->book->title) . '_' . $this->order_by;
	}

	public function getVerseCountAttribute()
	{
	    return $this->verses->count();
	}

	public function getStepsCountAttribute()
	{
	    return $this->steps->count();
	}

	public function getNextChapterAttribute()
	    {
		if($this->id === null){return new BibleChapter;}

		if ($this->id == 1189){
				$chapter = $this->find(1);
		}else{
			$chapter = $this->find($this->id+1);
		}

		  return $chapter;
	    }

	public function getPreviousChapterAttribute()
    {
		if($this->id === null){return new BibleChapter;}

		if ($this->id == 1){
			$chapter = $this->find(1189);
		}else{
			$chapter = $this->find($this->id-1);
		}

	  return $chapter;
    }
}
