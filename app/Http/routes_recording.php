<?php

Route::get('/r','RecordingsController@index');
Route::get('/r/{recording}','RecordingsController@show')
	->where('recording','(.*)');

Route::group(['prefix' => 'recordings'], function()
{

	Route::get('/','RecordingsController@index');
	Route::get('/search/{query}', ['uses' => 'RecordingsController@goToRecording']);
	Route::post('/search', ['uses' => 'RecordingsController@goToRecording']);
	Route::post('/recording-to-study', ['as' => 'recording-to-study','uses' => 'RecordingsController@addToStudy']);
	
});

Route::group(['prefix' => 'recording'], function()
{


	Route::get('/create','RecordingsController@create');
	Route::post('/create','RecordingsController@store');
	
	Route::get('/edit/{recording}','RecordingsController@edit');
	Route::post('/edit/{recording}','RecordingsController@update');
	
	Route::post('/create-format',[
	'uses'=>'RecordingsController@createFormat',
	'as'=>'create_recording_format'
	]);
	
	
	Route::post('/delete',[
	'uses'=>'RecordingsController@delete',
	'as'=>'delete_recording'
	]);
	
	Route::post('/delete-format',[
	'uses'=>'RecordingsController@destroyFormat',
	'as'=>'delete_recording_format'
	]);
	
	Route::post('/add-scripture',[
	'uses'=>'RecordingsController@addScripture',
	'as'=>'add_scripture_to_recording'
	]);
	
	Route::post('/detach-verse',[
	'uses'=>'RecordingsController@detachVerse',
	'as'=>'detach_recording_verse'
	]);
	
	Route::post('/attach-person',[
	'uses'=>'RecordingsController@attachPerson',
	'as'=>'attach_recording_person'
	]);
	Route::post('/detach-person',[
	'uses'=>'RecordingsController@detachPerson',
	'as'=>'detach_recording_person'
	]);
	
});
