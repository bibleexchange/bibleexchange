<?php

Route::group(array('prefix' => '/blog'), function()
{	
	Route::get('/','BlogController@index');
	Route::get('/{article_slug}','BlogController@index');
	
	Route::get('/tag/{tag}','BlogController@tagIndex');
	
});