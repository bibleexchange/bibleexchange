<?php namespace BibleExperience;

use BibleExperience\BibleReference;

class BibleVerse extends BaseModel {

	//protected $connection = 'scripture';
	protected $table = 'bibleverses';
	public $timestamps = false;
	protected $fillable = array('b','c','order_by','body','biblechapter_id','bible_version_id');
	protected $appends = array('chapterURL','reference','url','quote','notesCount','output','description','bookNumber','chapterNumber','verseNumber','previous', 'next');

	public function biblelist()
	{
	    return $this->belongsToMany('BibleExperience\BibleList','bibleverse_biblelist','bibleverse_id','biblelist_id');
	}

	public static function scopeSearch($query,$search)
	{
		return $query->where('body','LIKE','%'.$search.'%');
	}

	public static function getReferenceObject($referenceString)
	{
	  return new BibleReference($referenceString);
	}

	public static function findVersesByReference($reference)
	{
	  $ref = Self::getReferenceObject($reference);
	  return $ref->verses;
	}

	public static function findVersesByReferenceQuery($reference)
	{
	  $ref = Self::getReferenceObject($reference);
	  return $ref->verses;
	}

	public static function findByReference($reference)
	{
	  $ref = Self::getReferenceObject($reference);
	  return $ref->verses->first();
	}

	public function getBookNumberAttribute(){ return $this->b;}
	public function getChapterNumberAttribute(){ return $this->c;}
	public function getVerseNumberAttribute(){ return $this->order_by;}

	public function getUrlAttribute()
    {
    	if(isset($this->book)){
    		return '/bible/'.$this->book->slug.'_'.$this->c.'_'.$this->order_by;
    	}
	   
    }

	public function resourceUrl ()
	{
		return url($this->book->slug . '_' . $this->c . '_' . $this->order_by);
	}

	public function book()
	{
	    return $this->belongsTo('BibleExperience\BibleBook', 'b');
	}

	public function notebooks()
	{
		return $this->hasMany('\BibleExperience\Notebook','bible_verse_id');
	}

	public function notes()
	{
		return $this->hasMany('BibleExperience\Note','bible_verse_id');
	}

	public function crossReferences()
	{
		return $this->hasMany('BibleExperience\CrossReference','bible_verse_id');
	}

	public function studies()
	{
		return $this->hasMany('BibleExperience\Study','main_verse');
	}

	public function translations()
	{
		return $this->hasMany('BibleExperience\BibleTranslation','verse_id');
	}

	public function kjvrText(){

		if($this->translations()->kJVR()->first() != NULL){

			return $this->translations()->kJVR()->first()->text;

		} else {
			return $this->t;
		}

	}

	public function chapter()
	{
	    return $this->belongsTo('BibleExperience\BibleChapter', 'bible_chapter_id');
	}

	public function getChapterURLAttribute()
    {
	   if(isset($this->book)){
	   	return '/bible/'.$this->book->slug.'_'.$this->c;
	   }
    }

    public function getReferenceAttribute()
    {
    	if($this->book !== null) {return $this->book->title . ' ' . $this->c . ':' . $this->order_by;}
	return null;
    }

    public function getQuoteAttribute()
    {
    	if(isset($this->book)){
    	return '<blockquote><a href="'.$this->chapterURL.'">' . $this->book->title . ' ' . $this->c . ':' . $this->order_by . '</a>&mdash;' . $this->body.'</blockquote>'	;
    	}
    }

    public function quoteRelative($baseUrl)
    {
    	return '<blockquote><a href="'. $baseUrl . $this->chapterURL.'">' . $this->book->title . ' ' . $this->c . ':' . $this->order_by . '</a> &mdash;' . $this->t.'</blockquote>';
    }

    public function mdQuote()
    {
    	return '> ['.$this->book->title . ' ' . $this->c . ':' . $this->v.']('.$this->chapterURL.')&mdash;' . $this->t;
    }

    public function focus($string = null)
    {
    	if($string === NULL){
    		return $this->t;
    	}else{
    		//$verseStripped = preg_replace('/[^a-z]+/i', ' ', $verse);//keep only letters and numbers
    		$verse = $this->t;
    		$array = explode(strtolower($string),strtolower($verse),2);
    		$string = '<strong>'.strtoupper($string).'</strong>';
    		$startD = '';
    		$endD = '';

    		if (count($array) >=2){
    			if (strlen($array[0]) >=15){$startD = '...';}
    			if (strlen($array[1]) >=20){$endD = '...';}
    			return $startD.substr($array[0],-15,15).$string.substr($array[1],0,20).$endD;

    		}else{
    			return '...'.substr($array[0],-15,15).$string;
    		}
    	}

    }

    public function searches(){
    	return $this->belongsToMany('\BibleExperience\Services\Search')->withPivot('bible_verse_id', 'search_id');
    }

    public static function convertReferenceToQuote($reference){

    	$verse = self::isValidReference($reference);

    	if($verse)
    	{
    		return $verse->mdQuote();
    	}

    	return '{% INVALID-->'.$reference.'<--INVALID %}';
    }

	public function highlights()
	{
		return $this->hasMany('BibleExperience\BibleHighlight','bible_verse_id');
	}

	public function userHighlight($user)
	{
		return $this->hasMany('BibleExperience\BibleHighlight','bible_verse_id')->where('user_id', $user->id)->first();
	}

    public function getNotesCountAttribute()
    {
    	return $this->notes->count();
    }

    public function getOutputAttribute()
    {
    	return [
		"type"=>"BIBLE_VERSE",
		"value"=>json_encode($this->attributes)
	];
    }

    public function getDescriptionAttribute(){
    	if(isset($this->book)){
    	return $this->book->title . ' ' . $this->c . ':' . $this->order_by . '-' . $this->body . ' Read and Study more on Bible.exchange.';
    	}
    }

    public function getNextAttribute()
	    {
		if($this->id === null){return new BibleVerse;}

		if ($this->id === 66022021){
			$verse = $this->find(1001001);
		}else{
			$verse = $this->where('id', '>', $this->id)->first();
		}

		  return $verse;
	    }

	public function getPreviousAttribute()
    {
		if($this->id === null){return new BibleVerse;}

		if ($this->id === "01001001" || $this->id === 1001001){
			$verse = $this->find(66022021);
		}else{
			$verse = $this->where('id', '<', $this->id)->orderBy('id','DESC')->first();
		}

	  return $verse;
    }


}
