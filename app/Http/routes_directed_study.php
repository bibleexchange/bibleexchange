<?php

Route::group(array('prefix' => '/ds'), function()
{	
	
	Route::get('{aaa}','DirectedStudyController@show');
	
	Route::get('/','DirectedStudyController@index');
});