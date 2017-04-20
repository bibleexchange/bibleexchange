<?php namespace BibleExperience;

use BibleExperience\BibleVerse;

class BibleReference {

	var $input;
	var $start;
	var $end;

	public function __construct($referenceString){
	  $this->input = $this->setReference($referenceString);
	  $this->make();
	}
	
	public function make(){
	  
	  $this->start = new \stdClass();
	  $this->end =  new \stdClass();

	  $this->getStartBook()
		->getStartChapter()
		->getStartVerse()
		->getEndBook()
		->getEndChapter()
		->getEndVerse();
	}
	
	public function setReference($reference){
		$range = explode('-',$reference);

		$ref = new \stdClass();	
		$ref->start = new \stdClass();	
		$ref->end = new \stdClass();	

		$start = Self::refToArray($range[0], 'book');
		$end = isset($range[1]) ? Self::refToArray($range[1],'verse'):null;

		$ref->start->book = $start[0];
		$ref->start->chapter = isset($start[1]) ? $start[1]:null;
		$ref->start->verse = isset($start[2]) ? $start[2]:null;

		if($end === null){
		   $ref->end = null;
		}else{

		   if($end[0] === null){$book = $ref->start->book;}else{$book = $end[0];}
		   if($end[1] === null){$chapter = $ref->start->chapter;}else{$chapter = $end[1];}
		   if($end[2] === null){$verse = $ref->start->verse;}else{$verse = $end[2];}
		
		  $ref->end->book = $book;
		  $ref->end->chapter = $chapter;
		  $ref->end->verse = $verse;
		}
		$ref->string = $this->getReference($ref);

		return $ref;
	}

	public static function refToArray($reference, $ifOnlyOne = 'book')
	{
	
		$r = str_replace(' ','_',$reference);

		if(is_numeric(substr($r,0,1)) && substr($r,1,1) == "_"){
		  $r = preg_replace("~_~", "", $r, 1);
		}else if(is_numeric(substr($r,0,1)) && substr($r,1,1) != " "){
		  $r = substr($r,0,1) . "" . substr($r,1,20);
		}

		if (strpos($r, ':') !== false) {
		  $r = str_replace(':','_', $r);
		  $r = explode('_',$r);

			if(count($r) === 2){$r = array_merge([null],$r);}
			else if(count($r) === 1){$r = array_merge([null,null],$r);}
		  
		}else{
		  $r = explode('_',$r);
		  if(count($r) === 1 && $ifOnlyOne === 'verse'){
		    $r = array_merge([null,null],$r);
		  }else if(count($r) === 1 && $ifOnlyOne === 'book'){
		    $r = array_merge($r,[null,null]);
		  }else{
		    $r = array_merge($r,[null]);
		  }
		  
		}

		return $r;
		

	}

	public function getStartBook()
	{
	  $this->start->book = BibleBook::search($this->input->start->book)->first();
	  return $this;
	}

	public function getStartChapter()
	{
	  if($this->start->book === null ){$this->start->chapter = null; }else{
	    $this->start->chapter = $this->start->book->chapters()->where('order_by', $this->input->start->chapter)->first();
	  }
	  return $this;
	}

	public function getStartVerse()
	{
	  if($this->start->book === null || $this->start->chapter === null ){$this->start->verse = null; }else{
	  $this->start->verse = $this->start->book->chapters()->where('order_by', $this->input->start->chapter)->first()->verses()->where('order_by', $this->input->start->verse)->first();}
	  return $this;
	}

	public function getEndBook()
	{
	  if($this->input->end === null){
	    $this->end->book = null;
	  }else if($this->input->end->book !== null){
	    $this->end->book = BibleBook::search($this->input->end->book)->first();
	  }else{
	    $this->end->book = null;
	  }
	   
	  return $this;
	}

	public function getEndChapter()
	{

	  if($this->end->book === null){
	    $this->end->chapter = null;
	  }else if($this->input->end->book !== null){
	    $this->end->chapter = $this->end->book->chapters()->where('order_by', $this->input->end->chapter)->first();
	  }else{
	    $this->end->chapter = null;
	  }

	  return $this;
	}

	public function getEndVerse()
	{

	  if($this->end->chapter === null){ 
	    $this->end->verse = null;
	  }else{

		if($this->input->end->verse !== null && $this->input->end->verse <= $this->end->chapter->verseCount){
		     $this->end->verse = $this->end->chapter->verses()->where('order_by', $this->input->end->verse)->first();
		}else{
		     $this->end->verse = $this->end->chapter->verses->last();
		}
	  }
	  return $this;
	}

	public function versesInRange()
	{ 
	  if($this->end->verse === null){
	    if($this->start->chapter === null){return collect([]);}else 	
	    if($this->start->verse === null){return $this->start->chapter->verses;}else{ return collect([$this->start->verse]);} 
	  }else {
	    return BibleVerse::whereBetween('id', [$this->start->verse->id, $this->end->verse->id])->get();
	  }
	}

	public function chaptersInRange()
	{ 
	  if($this->start->chapter === null){ return collect([]);}
	  else if($this->end->chapter === null){return BibleChapter::where('id', $this->start->chapter->id)->get();}else{ 
	    return BibleChapter::whereBetween('id', [$this->start->chapter->id, $this->end->chapter->id])->get();
	  }
	}


	public function getReference($ref)
	{ 

		$string = ucfirst($ref->start->book);

		if($ref->start->chapter !== null){
			$string .= ' ' . $ref->start->chapter;
		}

		if($ref->start->verse !== null){
			$string .= ':' . $ref->start->verse;
		}
	  
	  return $string;

	}

	public function getMeta($meta)
	{ 

		if ($this->start->verse !== null) {
			$item = $this->start->verse;
		}else if($this->start->chapter !== null){
			$item = $this->start->chapter;
		}else if ($this->start->book !== null){
			$item = $this->start->book;
		}else{
			$item = new stdClass;
			$item->description = $meta->description;
		}

		$meta->title = 'Discover ' . $item->reference . ' from the Holy Bible on Bible Exchange';
	    $meta->keywords = "bible, scripture, faith";
	    $meta->author = "The Holy Bible";
	    $meta->description = $item->description;//No more than 155 characters
	    $meta->shareImage = 'https://bible.exchange/images/be_logo.png';//Twitter summary card with large image must be at least 280x150px
	    $meta->articlePublished = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
	    $meta->articleModified = '2015-02-25T19:08:47+01:00';//2013-09-16T19:08:47+01:00
	    $meta->articleSection = $item->reference;

	 return $meta;

	}


}
