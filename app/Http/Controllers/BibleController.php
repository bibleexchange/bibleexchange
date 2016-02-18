<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Entities\NoteRepository;
use BibleExchange\Entities\BibleBook;
use BibleExchange\Entities\BibleChapter;
use BibleExchange\Entities\BibleVerse;
use BibleExchange\Entities\BibleHighlight;
use Redirect,Auth,Input, Flash, Session;

class BibleController extends Controller {
	
	function __construct(NoteRepository $noteRepository){
		$this->noteRepository = $noteRepository;
	}
	
	public function getIndex()
	{		
		return $this->index();
		
	}
	
	public function index()
	{	

		
		if(Session::has('last_scripture')){

			return Redirect::to(url(Session::get('last_scripture')));
			
		}else{
		
		$book = BibleBook::find(40);
		$chapter = 1;
		
		return Redirect::to('/kjv/'.$book->slug.'/'.$chapter);
		}
		
		
	}

	public function getBook($book)
	{
		$booksOftheBible = BibleBook::all();
		return view('bible.book', compact('book','booksOftheBible'));
	}
	
	public function getVerse($book,$chapter,$verseByv)
	{					
		$booksOftheBible = BibleBook::all();
		$verse = $book->chapters[$chapter-1]->verses[$verseByv-1];
		$this->noteRepository = new NoteRepository;
		if(Auth::user()){
			$notes = $this->noteRepository->getFeedForUserWhereVerse(Auth::user(),$verse);
		}else{
			$notes = $this->noteRepository->getFeedForPublicNotesWhereVerse($verse);
		}
		
		$versePage = true;
		$notes_per_page = 5;
		$data_path = '/api/v1/notes/bible/verse/'.$verse->id."?count=".$notes_per_page;
		
		return view('bible.verse', compact('verse','booksOftheBible','notes','versePage','notes_per_page','data_path'));
	}
	
	public function postVerse()
	{
		$verse_id = (Input::get('verse'));
		$verse = BibleVerse::find($verse_id);
		return Redirect::to($verse->chapterURL);
	}
	
	public function getChapterVerses($book,$chapterOrderBy,$verse = null)
	{		
		$booksOftheBible = BibleBook::all();
		$chapter = $book->chaptersByOrderBy($chapterOrderBy);
		
		if (isset($_GET['verse'])){$urlVerse = $_GET['verse'];}else {$urlVerse = $verse;}
		
		if(Auth::check()){
			$notes = $this->noteRepository->getFeedForUserWhereVerses(Auth::user(),$chapter->verses->lists('id')->toArray());
		}else{			
			$notes = $this->noteRepository->getFeedForPublicNotesWhereVerses($chapter->verses->lists('id')->toArray());
		}
		
		$currentReference = $book->n.' '.$chapter->orderBy;
		
		if ($urlVerse !== null){
			
			$currentReference = $currentReference.':'.$urlVerse;
		}
		
		$notes_per_page = 3;
		$data_path = '/api/v1/notes/bible/'.$chapter->book->slug.'/'.$chapterOrderBy."?count=".$notes_per_page;
		
		\Session::put('last_scripture', $chapter->url());
		\Session::put('last_scripture_readable', $currentReference);
		
		$highlight_colors = BibleHighlight::getColors();
		
		return view('bible.chapter', compact('book','chapter','urlVerse','booksOftheBible','notes','currentReference','notes_per_page','data_path','highlight_colors'));
	}
	
	public function getSearch()
	{			

		$booksOftheBible = BibleBook::all();
		$search = Input::get('q');
		$verses = BibleVerse::searchForVerses($search);

		if (empty($verses)){
		
			Flash::message('I couldn\'t find that verse. Maybe these results will help.');
		
			return Redirect::to('/search/'.$search);
		}
		
		if (count($verses) === 1){
			return Redirect::to($verses[0]->url());
		}
		
		return view('bible.search', compact('verses','search','booksOftheBible'));
	}
	
}