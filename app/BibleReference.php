<?php namespace BibleExperience;

use BibleExperience\BibleVerse;
use stdClass, DB;

class BibleReference {

	var $reference;
	var $ranges;
	var $verses;

	public function __construct($referenceString){
	  $this->reference = $referenceString;
	  $this->verses = collect([]);
	  $this->make();
	}
	
	public function make(){
	  $this->cleanReference()->beforeAll()->getVerses();
	}
	
	public function cleanReference(){
		$this->reference = trim(str_replace("_"," ",$this->reference));
		return $this;
	}

	public function getRange($reference){
		$range = new stdClass;
		$range->string = trim($reference);

		$array = str_split(trim($reference));

		$book = "";
		$chapter = "";
		$verse = "";
		$bookDone = false;
		$chapterDone = false;

		foreach($array AS $char){

			if($book === ""){
				$book .= $char;
			}else{

				if(!$bookDone && is_numeric($char)){
					$bookDone = true;
					$chapter .= $char;
				}else if($chapterDone){
					$verse .= $char;
				}else if($char === ":" ){
					$chapterDone = true;
				}else if($bookDone){
					$chapter .= $char;
				}else{
					$book .= $char;
				}

			}
			

		}

		

		$book = str_replace(" ","", strtolower($book));

		if(strpos($book, '2john') !== false || strpos($book, '3john') !== false || strpos($book, 'diah') !== false || strpos($book, 'ilemon') !== false || strpos($book, 'ude') !== false){
			$verse = $chapter;
			$chapter = 1;
		}

		//Done finding book, chapter & verse
		$range->start = new stdClass;
		$range->end = new stdClass;

		$range->start->book = str_replace("ii","2",str_replace("iii","3",trim($book)));
		$range->end->book = str_replace("ii","2",str_replace("iii","3",trim($book)));

		if($range->start->book[0] === "i"){
			$range->start->book[0] = "1";
		}

		if($range->end->book[0] === "i"){
			$range->end->book[0] = "1";
		}

		//Checking if chapter value is actually a range of chapters
		if(strpos($chapter,"-") !== false){
			$chapter = explode("-",$chapter, 2);
			$range->start->chapter = intval(trim($chapter[0]));
			$range->end->chapter = intval(trim($chapter[1]));

		}else{
			$range->end->chapter = intval(trim($chapter));
			$range->start->chapter = intval(trim($chapter));
		}

		//Checking if verse value is actually a range of verses
		if(strpos($verse,"-") !== false){
			$verse = explode("-",$verse, 2);

			$range->start->verse = intval($verse[0]);
			$range->end->verse = intval($verse[1]);

		}else{
			$range->start->verse = intval($verse);
			$range->end->verse = intval($verse);
		}

		if($range->start->verse === "" || $range->start->verse === 0){
			$range->start->verse = 1;
		}

		if($range->end->verse === "" || $range->end->verse === 0){
			$range->end->verse = 200;
		}

		return $range;
	}

	public function beforeAll(){

		$references = explode(";",$this->reference);
		$r = new stdClass;
		$r = [];
		foreach($references AS $ref){
			if($ref !== ""){
				$r[] = $this->getRange($ref);
			}
			
		}

		$this->ranges = $r;

		return $this;
	}

	public function getVerses()
	{	
		$ctr = 0;
		$verses = null;
		$chapters = [];

		foreach($this->ranges AS $range){
			

		if(is_object($range->start->book)){
			$sbook = $range->start->book;
			$ebook = $range->end->book;
		}else{
			$sbook = BibleBook::search($range->start->book)->first();
			$ebook = BibleBook::search($range->end->book)->first();
		}
			
		if($sbook === null){

			if($verses === null){
				$verses = BibleVerse::search($this->reference);
			}else{
				$verses = $verses->search($this->reference);
			}

		}else{

			$startVerse = sprintf('%02d', $sbook->id) . sprintf('%03d', $range->start->chapter) . sprintf('%03d', $range->start->verse);
			$endVerse = sprintf('%02d', $ebook->id) . sprintf('%03d', $range->end->chapter) . sprintf('%03d', $range->end->verse);

			$this->ranges[$ctr]->start->verse = $startVerse;
			$this->ranges[$ctr]->end->verse = $endVerse;

			if($startVerse === $endVerse){

				if($verses === null){
					$verses = BibleVerse::where("id",$startVerse);
				}else{
					$verses = $verses->orWhere("id",$startVerse);
				}
				
			}else{

				if($verses === null){
					$verses = BibleVerse::whereBetween("id",[$startVerse,$endVerse]);
				}else{
					$verses = $verses->orWhereBetween("id",[$startVerse, $endVerse]);
				}
			}
			
		}

			$this->ranges[$ctr]->start->book = $sbook;
			$this->ranges[$ctr]->end->book = $ebook;

			$ctr = $ctr+1;
		}
	  	
	  $this->verses = $verses;
	  return $this;
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
			$item->reference = "";
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
