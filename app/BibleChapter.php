<?php namespace BibleExperience;

use Str,stdClass;
use BibleExperience\BibleReference;

class BibleChapter extends BaseModel {

	//protected $connection = 'scripture';
	protected $table = 'biblechapters';
	protected $fillable = array('bible_book_id','order_by','summary');
	protected $appends = array('url','reference','referenceSlug','previousChapter','nextChapter','verseCount', 'stepsCount');

	public static function getReferenceObject($referenceString)
	{
	  return new BibleReference($referenceString);
	}

	public static function findChaptersByReference($reference)
	{

	  $ref = Self::getReferenceObject($reference);
	  return $ref->chaptersInRange();
	}

	public static function findByReference($referenceArray)
	{
	  $search_book_title = $referenceArray[0];
	  $book = \BibleExperience\BibleBook::where('slug','like',$search_book_title."%")->first();

	  if(!isset($referenceArray[1])){//If there is only a book title given then grab first chapter

		if($book == null){
		  return null;
		}else{
		  return $book->chapters()->where('order_by', 1)->first();
		}

	  }

	  $chapter = $referenceArray[1];


	if($book !== null){
	  $chapter = $book->chapters()->where('order_by', "{$chapter}")->first();
	  if($chapter !== null){return $chapter;}else{return null;}
	}
	return null;

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
