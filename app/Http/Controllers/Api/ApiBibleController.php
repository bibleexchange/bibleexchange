<?php namespace BibleExperience\Http\Controllers\Api;

use BibleExperience\Entities\BibleBook;
use BibleExperience\Entities\BibleChapter;
use BibleExperience\Entities\BibleVerse;
use BibleExperience\Services\Search;
use BibleExperience\Entities\Tag;
use BibleExperience\Entities\Transformers\BibleTransformer;
use BibleExperience\Entities\BibleHighlight;
use Illuminate\Http\JsonResponse;

use Input, Auth, Response, Str;

class ApiBibleController extends ApiController {
	/**
	 * 
	 *
	 * @var /Entities/Transformers/LessonTransformer
	 */
	protected $bibleTransformer;
	
	function __construct(BibleTransformer $bibleTransformer){
		
		$this->bibleTransformer = $bibleTransformer;
		
		$this->middleware('auth.basic',['only'=>['store']]);
	}
	

	public function recipes(){
		$headers = [];
		$data = file_get_contents('db.json');
		return new JsonResponse(json_decode($data), 200, $headers);

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lessonId = null)
	{
		
		$tags = $this->getTags($lessonId);
		
		return $this->respond([
			'data'=>$this->bibleTransformer->transformCollection($tags->all())
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$verse = BibleVerse::find($id);
		
		if(! $verse){
			
			return $this->respondNotFound('Verse does not exist.');
			
		}
		
		return $this->respond([
				'data'=>$this->bibleTransformer->transform($verse)
		]);
		
	}
	
public function showChapter($chapter)
	{
		
		if(! $chapter){
			
			return $this->respondNotFound('Chapter does not exist.');
			
		}
		
		$currentReference = $chapter->book->n.' '.$chapter->orderBy;
	
		\Session::put('last_scripture', $chapter->url());
		\Session::put('last_scripture_readable', $currentReference);

		return $this->respond([
				'data'=>$this->bibleTransformer->transformChapter($chapter)
		]);

	}
	
public function showChapterView($chapter)
	{
		$booksOftheBible = BibleBook::all();
		$currentReference = $chapter->book->n.' '.$chapter->orderBy;
		
		\Session::put('last_scripture', $chapter->url());
		\Session::put('last_scripture_readable', $currentReference);
		
		$highlight_colors = BibleHighlight::getColors();
		
		return view('bible.chapter-min', compact('book','chapter','booksOftheBible','currentReference','highlight_colors'));
	}

	public function searchReference($term)
	{
		
		$verse = BibleVerse::isValidReference($term);
		
		if($verse !== false){
			
			return $verse->chapter->id;
			
		}else{
			
			return 'empty';
			
		}
		
	}
	
	public function convertReferenceToChapter($term)
	{
		
		$verse = BibleVerse::isValidReference($term);
		
		if($verse !== false){
			
			return $this->showChapter($verse->chapter);
			
		}else{
			
			return 'empty';
			
		}
		
	}
	
	
	public function search($query)
	{
	
		$search = new Search;
		$results = $search->site($query);
		
		$studies = $results->studies->paginate(15);
		$bibleVerses = $results->bibleVerses->paginate(15);
		$bibleBooks = $results->bibleBooks->paginate(15);
		
		if($results === NULL){Flash::message('We couldn\'t find anything like that!');}
		
		return view('searches.index-min',compact('studies','bibleVerses','bibleBooks','query'));
	
	}
	
}
