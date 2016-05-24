<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
//23555
//ini_set('memory_limit', '-1'); 
//ini_set('max_execution_time', 15000);

@include(__DIR__.'../GraphQL/routes.php');

Route::group(['middleware' => 'cors'], function(){

	Route::get('/',function(){
		//return BibleExchange\Entities\Note::where('bible_verse_id','20008022')->get();
		//return BibleExchange\Entities\Note::find(87)->getObject();
		//return BibleExchange\Entities\Notebook::all();
		//return BibleExchange\Entities\Notebook::with('notes')->find(1);
		//return BibleExchange\Entities\BibleVerse::with('notebooks')->find(66001001);
		//return BibleExchange\Entities\BibleVerse::with('notes')->find(66003019);
		//return BibleExchange\Entities\BibleChapter::with('notes')->find(1170);
		
		//1-6000
		//6,001-12,000
		//12,001-18,000
		//18,001 - 24,000
		//24,001-30,000
		$id = 79835;
		
		for ($x = 99339; $x <= 110000; $x++) {
			
			$use = BibleExchange\Entities\CrossReference::find($x);
			
			if($use){
				
				//$use->delete();
				/*
				$note = new BibleExchange\Entities\Note;
				$note->body = "Compare with this verse";
				$note->bible_verse_id = $use->vid;
				$note->image_id = null;
				$note->user_id = 1;
				$note->object_id = $use->sv;
				$note->object_type = "BibleVerse";
				$note->save();
				*/
			}
		} 
	});
	
});

