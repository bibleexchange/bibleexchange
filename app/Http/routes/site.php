<?php

/*
|------------------------------------------------------------------
| Site (this is for super admin users only)
|------------------------------------------------------------------
*/

Route::group(['prefix' => 'site'], function () {

	Route::get('/', array(
	  'as'   => 'site.index',
	  'uses' => 'SiteController@index',
	));
	Route::get('settings', array(
	  'uses' => 'SiteController@settings',
	));
	Route::get('apps', array(
	  'uses' => 'SiteController@apps',
	));
	Route::get('stats', array(
	  'uses' => 'SiteController@getStats',
	));
	Route::get('graphdata', array(
	  'uses' => 'SiteController@getGraphData',
	));
	Route::get('lrs', array(
	  'uses' => 'SiteController@lrs',
	));
	Route::get('users', array(
	  'uses' => 'SiteController@users',
	));
	Route::get('invite', array(
	  'uses' => 'SiteController@inviteUsersForm',
	  'as'   => 'site.invite'
	));
	Route::post('invite', array(
	  'uses' => 'SiteController@inviteUsers',
	));
	Route::get('plugins', array(
	  'uses' => 'PluginController@index',
	));
	Route::resource('/', 'SiteController');
	Route::put('users/verify/{id}', array(
	  'uses' => 'SiteController@verifyUser',
	  'as'   => 'user.verify'
	));

});
