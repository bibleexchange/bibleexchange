<?php namespace BibleExchange\Entities;

class BibleVerse extends \Eloquent {
	
	//protected $connection = 'scripture';
	protected $table = 't_kjv';
	public $timestamps = false;
	protected $fillable = array('b','c','v','t','biblechapter_id');
	protected $appends = array('chapterURL','reference','url','quote');
	
	public static function scopeSearch($query,$search)
	{
		return $query->where('t_kjv.t','LIKE','%'.$search.'%');
	
	}
	
	public static function isValidReference($reference){
		
		//places a . between book name and reference.
		//i.e. changes "Song of Solomon 9:6" to "Song of Solomon.9:6"
		$string = preg_replace('/\s(\S*)$/', '.$1', trim($reference)); //trim end for sanitization.
		$verse_number = 1;
	
		//split
		$separatedArray = explode(".",$string);
		$bible = new BibleBook;
		
		$book = $bible->findByName($separatedArray[0]);
		
		if(!is_object($book))
		{
			return false;
		}
		
		//split chapter and verse
		
		if(!isset($separatedArray[1]))
		{
			return false;
		}
		
		$separatedVerse = explode(":",$separatedArray[1]);

		$chapter = $book->chaptersByOrderBy($separatedVerse[0]);

		if($separatedVerse[0] > $book->chapters->count())
		{
			return false;
		}
		
		if(isset($separatedVerse[1])){
			
			$verse_number = $separatedVerse[1];
		}
		
		$verse = sprintf("%02s", $book->id).sprintf("%03s", $chapter->orderBy).sprintf("%03s", $verse_number);
		
		if (BibleVerse::find($verse) !== NULL){
			return BibleVerse::find($verse);
		}
		
		return false;
		
	}
	
	public function url($option = null)
	{		
		return '/bible/' . $this->book->slug . '/' . $this->c . '#'.$this->id;
	
	}
	
	public function resourceUrl ()
	{
		return url($this->book->slug . '_' . $this->c . '_' . $this->v);
	}
	
	public function book()
	{
	    return $this->belongsTo('BibleExchange\Entities\BibleBook', 'b');
	}
	
	public function notes()
	{
		return $this->hasMany('BibleExchange\Entities\Note','bible_verse_id');
	}
	
	public function crossReferences()
	{
		return $this->hasMany('BibleExchange\Entities\CrossReference','vid');
	}
	
	public function studies()
	{
		return $this->hasMany('BibleExchange\Entities\Study','main_verse');
	}
	
	public function translations()
	{
		return $this->hasMany('BibleExchange\Entities\BibleTranslation','verse_id');
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
	    return $this->belongsTo('BibleExchange\Entities\BibleChapter', 'bible_chapter_id');
	}
	
	public function getChapterURLAttribute()
    {	
	   return '/bible/'.$this->book->slug.'/'.$this->c.'#'.$this->id;
    }
	
	public function getReferenceAttribute()
    {	       	
    	return $this->book->n . ' ' . $this->c . ':' . $this->v;
    }
	
    public function getQuoteAttribute()
    {
    	return '<blockquote><a href="'.$this->chapterURL.'">' . $this->book->n . ' ' . $this->c . ':' . $this->v . '</a>&mdash;' . $this->t.'</blockquote>';
    }
    
    public function mdQuote()
    {
    	return '> ['.$this->book->n . ' ' . $this->c . ':' . $this->v.']('.$this->chapterURL.')&mdash;' . $this->t;
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
    			var_dump($array);
    			return '...'.substr($array[0],-15,15).$string;
    		}
    	}
    	
    }
    
    public function searches(){
    	return $this->belongsToMany('\BibleExchange\Services\Search')->withPivot('bible_verse_id', 'search_id');
    }
    
    public static function convertReferenceToQuote($reference){

    	$verse = self::isValidReference($reference);

    	if($verse)
    	{
    		return $verse->mdQuote();
    	}
    	
    	return '{% INVALID-->'.$reference.'<--INVALID %}';
    }
    
	public static function referenceTranslator($string){
		
		$references = explode(',',$string);
		$arrayOfVerses = [];

		foreach($references AS $string){
		
			$string = str_replace(';',':',$string);
			$string = preg_replace('/([0-9]?)\s?(\w*)/', '$1$2.', trim($string)); //trim end for sanitization.
	
			//split
			$separatedArray = array_values( array_filter(explode(".",$string)) );
			$bible = new BibleBook;
			$book = $bible->findByName(trim($separatedArray[0]));

			if(is_object($book))
			{
				//check if there is no chapter

				if(!isset($separatedArray[1]) || trim($separatedArray[1]) == "")
				{
					if(isset($books[1])){
						$bible3 = new BibleBook;
						$book2 = $bible3->findByName(trim(str_replace('-','',$books[1])));
						
						$start_verse_id = sprintf("%02s", $book->id).'001001';
						$end_verse_id = sprintf("%02s", $book2->id).'999999';
						
						$verses = BibleVerse::whereBetween('id', [$start_verse_id , $end_verse_id])->get();
						$arrayOfVerses = array_merge($arrayOfVerses, $verses->all());
					}else{
						foreach($book->verses AS $verse){
							$arrayOfVerses[] = $verse;
						}
					}
				}else{

					//split chapter and verse

					if(!isset($separatedArray[2]))
					{
						$verses = $book->chaptersByOrderBy($separatedArray[1]);
						
						if($verses !== null){
							foreach($verses->verses AS $verse){
								$arrayOfVerses[] = $verse;
							}					
						}else{
							$arrayOfVerses = array_merge($arrayOfVerses, $book->verses->all());
							
							$bible4 = new BibleBook;
							$book3 = $bible4->findByName(trim(str_replace('-','',$separatedArray[1])));
							$arrayOfVerses =  array_merge($arrayOfVerses, $book3->verses->all());
						}	
					}else{

						$chapter = $book->chaptersByOrderBy($separatedArray[1]);
				
						if($chapter !== null)
						{
							$start_verse = str_replace(':','',$separatedArray[2]);	
							$start_verse_id = sprintf("%02s", $book->id).sprintf("%03s", $chapter->orderBy).sprintf("%03s", $start_verse);
							$verseObject = BibleVerse::find($start_verse_id);
							
							if($verseObject != null){
							
							///////////////////////////////////////////////////////////////////////////
								if (isset($separatedArray[3])) {
									
									if(preg_match('/[a-zA-Z]/',$separatedArray[3]) >= 1){
										
										$name = trim(str_replace('-','',$separatedArray[3]));
										$bible2 = new BibleBook;
										$book2 = $bible2->findByName(trim($name));
										$book_code = sprintf("%02s", $book2->id);
										
										if(isset($separatedArray[4])){
											
											$chapter_code = sprintf("%03s",$separatedArray[4]);
											
											if(isset($separatedArray[5])){
												$verse_code = sprintf("%03s", trim(str_replace(':','',$separatedArray[5])));
											}else{
												$verse_code = '001';
											}
										}else{
											$chapter_code = '999';
											$verse_code = '999';
										}
									}else{
										$book_code = sprintf("%02s", $book->id);
										if(isset($separatedArray[2])){
											$chapter_code = sprintf("%03s", $separatedArray[1]);
											$verse_code = sprintf("%03s", str_replace('-','',$separatedArray[3]));
										}else{
											$chapter_code = sprintf("%03s", $chapter->orderBy);
											$verse_code = sprintf("%03s", "999");
										}
									}
									
									$end_verse_id = $book_code.$chapter_code.$verse_code;									
									$verses = BibleVerse::whereBetween('id', [$start_verse_id , $end_verse_id])->get();

									$arrayOfVerses = array_merge($arrayOfVerses, $verses->all());
	
								}else {
									$arrayOfVerses[] = BibleVerse::find($start_verse_id);
								}
								
							////////////////////////////////////////////////////////////////////////
							}
						}
					}
				}
			}
		}	

		return $arrayOfVerses;
	}
		
	public static function searchForVerses($search){
		
		$referencesSearched = explode(",",$search);
		
		foreach ($referencesSearched AS $v){
				
			$verseId = BibleVerse::referenceTranslator($v);
			
			if ($verseId === null) {
				$verses = [];
			}else{
			
				foreach($verseId AS $id){
						
					$verses[] = BibleVerse::find($id);
				}
			}
		}
		
		return $verses;
	}
	
	public function highlights()
	{
		return $this->hasMany('BibleExchange\Entities\BibleHighlight','bible_verse_id');
	}
	
	public function userHighlight($user)
	{
		return $this->hasMany('BibleExchange\Entities\BibleHighlight','bible_verse_id')->where('user_id', $user->id)->first();
	}
	
	
}