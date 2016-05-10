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

Route::group(['middleware' => 'cors'], function(){

	Route::get('/',function(){
		//return BibleExchange\Entities\Note::where('bible_verse_id','20008022')->get();
		//return BibleExchange\Entities\Note::find(87)->getObject();
		//return BibleExchange\Entities\Notebook::all();
		//return BibleExchange\Entities\Notebook::with('notes')->find(1);
		//return BibleExchange\Entities\BibleVerse::with('notebooks')->find(66001001);
		return BibleExchange\Entities\BibleVerse::with('notes')->find(66003019);
		//return BibleExchange\Entities\BibleChapter::with('notes')->find(1170);
	});
	
});

