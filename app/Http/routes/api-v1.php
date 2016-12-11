<?php

/*
|------------------------------------------------------------------
| Learning Locker RESTful API
|------------------------------------------------------------------
*/

Route::group( array('prefix' => 'api/v1','middleware'=>['auth.basic','cors']), function(){

  Config::set('api.using_version', 'v1');

  Route::get('/', function() {
    return Response::json( array('version' => Config::get('api.using_version')));
  });
  
  Route::get('query/analytics','Api\Analytics@index');
  Route::get('query/statements', 'Api\Statements@index');

  Route::resource('exports', 'Api\Exports');
  Route::get('exports/{id}/show','Api\Exports@showJson');
  Route::get('exports/{id}/show/csv','Api\Exports@showCsv');

  // Adds routes for reports.
  Route::resource('reports', 'Api\Reports');
  Route::get('reports/{id}/run', 'Api\Reports@run');
  Route::get('reports/{id}/graph', 'Api\Reports@graph');

  // Adds routes for statements.
  Route::get('statements/where','Api\Statements@where');
  Route::get('statements/aggregate','Api\Statements@aggregate');
  Route::get('statements/aggregate/time', 'Api\Statements@aggregateTime');
  Route::get('statements/aggregate/object','Api\Statements@aggregateObject');

  Route::post('bible','Api\BibleController@index');
  
});
