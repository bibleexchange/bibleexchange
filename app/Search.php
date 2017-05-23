<?php namespace BibleExperience;

use BibleExperience\BibleChapter;
use BibleExperience\BibleVerse;
use stdClass;

class Search {

	public function __construct($args)
	{
		$this->term = $args['filter'];
		$this->verses = collect([]);
	}

	function verses($args){
		//$this->bibleChapter = BibleChapter::findByReference($args['filter']);
		//$bibleVerses = BibleVerse::search($this->term)->skip($args['after'])->take($args['first'])->get();
		$this->verses = BibleVerse::search($this->term)->get();
		return $this->verses;
	}

}
