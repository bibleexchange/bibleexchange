<?php namespace BibleExperience\Http\Controllers\Api;

use \Response as IlluminateResponse;
use \BibleExperience\BibleBook;

class BibleController extends Base {

  public function index() {
    // should top timeouts on long queries
    set_time_limit(0);
	$query = JSON_DECODE(\Request::get('query'));



	$book = BibleBook::find($query->book);
	$chapter = $book->chapters()->where('orderBy',$query->chapter)->first();
	
	$verse = $chapter->verses()->where('v',$query->verse)->first();
	
	$take = 2;
	$skip = ($query->notes-1) * $take;
	$noteList = $chapter->notes()->skip($skip)->take($take)->get();
	
	$notes = new \stdClass();
	$notes->items = $noteList;
	$notes->total = $chapter->notes->count();
	$notes->lastpage = ceil($notes->total / $take);
	$notes->perPage = $take;
    $notes->currentPage = $query->notes;
	
	return response()->json([
    'book' => $book,
    'chapter' => $chapter,
	'verse'=> $verse,
	'notes'=> $notes
]);
  }

 
}