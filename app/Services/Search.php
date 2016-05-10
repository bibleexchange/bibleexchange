<?php namespace BibleExchange\Services;

use Illuminate\Support\Collection;
use stdClass, Str, View;
use BibleExchange\Entities\BibleBook as BibleBook;
use BibleExchange\Entities\BibleVerse as BibleVerse;
use BibleExchange\Entities\Study as Study;

class Search extends \Eloquent {
	
	protected $fillable = ['url','title','summary'];
	
	public function site($string){
		
		$results = new \stdClass();
		
		$results->studies = $this->studies($string);
		$results->bibleVerses = $this->bibleVerses($string);
		$results->bibleBooks = $this->bibleBooks($string);
		
		return $results;
	}
	
	public function studies($search)
	{
		return Study::search($search);
	}
	
	public function bibleVerses($search)
	{
		return BibleVerse::search($search);
	}
	
	public function bibleBooks($search)
	{
		return BibleBook::search($search);
	}
	public function verses(){
		return $this->belongsToMany('\BibleExchange\Entities\BibleVerse')->withPivot('bible_verse_id', 'search_id');
	}
	
	public static function build(){
	
		$studies = Study::all();
		$skip = [' a ', ' all ',' am ',' an ',' and ',' any ',' are ',' as ',' at ',' be ',' but ',' can ',' did ',' do ',' does ',' for ',' from ',' had ',' has ',' have ',' here ',' how ',
				' i ',' if ',' in ',' is ',' it ',' no ',' not ',' of ',' on ',' or ',' so ',' that ',' the ',' then ',' there ',' this ',' to ',' too ',' up ',' use ',' what ',' when ',
				' where ',' who ',' why ',' you ',' was ',' the ','The ',' it ','It ',' with ',' his ',' v ',' nbsp ','I ',' unto ',' by ',' we ',' as ',' our ','Our ',
				' s ',' S ',' us ','&apos;s','&nbsp;','&hellip;','&#44;','&mdash;','&ndash;','&ldquo;','&rdquo;','&quot;','&amp;',' Ch ',' being ','In ','His ',' him ',' and ','And ','As ',' his ',' will ','He ',' he ',' will ',' its ',' blank ','  '];
	
		foreach($studies As $l){
	
			$page = new \stdClass();
			$page->url = $l->defaultUrl;
			$page->title = $l->title;
			$page->summary = Str::words(strip_tags($l->content), 60);
			$page->article = file_get_contents($l->defaultUrl);
			$page->article = preg_replace('/<script>(.*?)<\/script>/s', '', $page->article);//ignore script
			$page->article = preg_replace('/<style>(.*?)<\/style>/s', '', $page->article);//ignore style
			$page->article = preg_replace('/<nav(.*?)<\/nav>/s', '', $page->article);//ignore navs
			$page->article = preg_replace('/<footer(.*?)<\/footer>/s', '', $page->article);//ignore footer
			$page->article = preg_replace('/<iframe(.*?)<\/iframe>/s', '', $page->article);//ignore iframes
			$page->article = str_replace($skip,' ', $page->article );//delete skip words
	
			$page->article = strip_tags($page->article);
	
			preg_match_all('/(?:[1-3]\s*)?[A-Z]?[a-z]+\s*\d+:\d*/',$page->article,$scriptures, PREG_PATTERN_ORDER);//finding scripture references
	
			$page->article = preg_replace('/[^a-z]+/i', ' ', $page->article);//keep only letters and numbers
			$words = explode(' ', $page->article);
			$page->keywords = [];
			$uniqueStrings = ['s','is','a','in','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','i','e','v','vs','vv','or','To','and','t','it'];
	
			foreach ($words AS $w){
	
				if (!empty($w)){
					$occurences = substr_count($page->article,$w);
					if(!in_array(trim($w), $uniqueStrings)){
						$uniqueStrings[] = trim($w);
						$page->keywords[] = ['word'=>trim($w),'count'=>$occurences];
					}
				}
			}
				
			$page->scriptures = [];
				
			foreach($scriptures As $s){
				foreach($s AS $b){
					$page->scriptures[] = BibleVerse::referenceTranslator($b);
				}
			}
			$lessonsPages[] = $page;
		}
			
		//url, title, summary, keywords:word, keywords:count, scriptures
		$pages = $lessonsPages;

		return $pages;
	
	}
	
}