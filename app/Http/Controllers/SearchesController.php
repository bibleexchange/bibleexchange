<?php namespace BibleExchange\Http\Controllers;

use BibleExchange\Services\Search;
use Redirect, Input;

class SearchesController extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /searches
	 *
	 * @return Response
	 */
	public function index()
	{
		$query = false;
		
		return view('searches.index',compact('query'));
	}
	
	public function store(){	
		return Redirect::to('/search/'.Input::get('q'));
	}
	
	public function show($query){
			
			$search = new Search;
			$results = $search->site($query);
				
			$studies = $results->studies->paginate(15);
			$bibleVerses = $results->bibleVerses->paginate(15);
			$bibleBooks = $results->bibleBooks->paginate(15);
				
			if($results === NULL){Flash::message('We couldn\'t find anything like that!');}
		
		return view('searches.index',compact('studies','bibleVerses','bibleBooks','query'));
	}
	
	public function build(){
		
		return Search::build();
		//return View::make('searches.build',compact('pages'));
	}
	
	public function getData()
	{
		if (Cache::has('sitewide_data')){
			return Cache::get('sitewide_data');
		}else{
			$set = $this->build();
			Cache::add('sitewide_data',$set,1400);
			return $set;
		}
		
	}

	public function findSomething($string)
	{
		$object = \BibleExchange\Entities\UrlShort::where('url',$string)->first();
		
		if($object !== null){
			
			$object->hits = $object->hits + 1;
			$object->save();
			
			$object = $object->getObject();
			
			return Redirect::to($object->url());
			
		}else {
			
			return Redirect::to('/study/'.$string);
		}
	}
	
}