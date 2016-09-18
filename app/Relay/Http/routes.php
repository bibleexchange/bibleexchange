<?php

/*
|------------------------------------------------------------------
| Site (this is for super admin users only)
|------------------------------------------------------------------
*/

Route::group(['prefix' => '/graphql'], function () {

  Route::get('/', '\BibleExperience\Relay\Http\Controllers\MainController@index');
  Route::post('/', '\BibleExperience\Relay\Http\Controllers\MainController@indexPost');

});

