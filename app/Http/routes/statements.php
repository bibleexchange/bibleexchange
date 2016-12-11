<?php
/*
|------------------------------------------------------------------
| Statements
|------------------------------------------------------------------
*/

Route::get('lrs/{id}/statements/generator', 'StatementController@create');
Route::get('lrs/{id}/statements/explorer/{extra?}', 'ExplorerController@explore')
->where(array('extra' => '.*'));
Route::get('lrs/{id}/statements/{extra}', 'ExplorerController@filter')
->where(array('extra' => '.*'));

Route::resource('statements', 'StatementController');

/*
|------------------------------------------------------------------
| Statement API
|------------------------------------------------------------------
*/

Route::get('data/xAPI/about', function() {
  return Response::json([
    'X-Experience-API-Version'=>Config::get('xapi.using_version'),
    'version' => [\Config::get('xapi.using_version')]
  ]);
});

Route::group( array('prefix' => 'data/xAPI', 'middleware'=>'auth.statement'), function(){

  Config::set('xapi.using_version', '1.0.1');

  // Statement API.
  Route::get('statements/grouped', array(
    'uses' => 'xAPI\StatementController@grouped',
  ));
  Route::any('statements', [
    'uses' => 'xAPI\StatementController@selectMethod',
    'as' => 'xapi.statement'
  ]);

  // Agent API.
  Route::any('agents/profile', [
    'uses' => 'xAPI\AgentController@selectMethod'
  ]);
  Route::get('agents', [
    'uses' => 'xAPI\AgentController@search'
  ]);

  // Activiy API.
  Route::any('activities/profile', [
    'uses' => 'xAPI\ActivityController@selectMethod'
  ]);
  Route::get('activities', [
    'uses' => 'xAPI\ActivityController@full'
  ]);

  // State API.
  Route::any('activities/state', [
    'uses' => 'xAPI\StateController@selectMethod'
  ]);

  //Basic Request API
  Route::post('Basic/request', array(
    'uses' => 'xAPI\BasicRequestController@store',
  ));

});

Route::group(['prefix' => 'api/v2', 'middleware' => 'auth.basic','auth.statement'], function () {
  Route::get('statements/insert', ['uses' => 'API\Statements@insert']);
  Route::get('statements', ['uses' => 'API\Statements@insert']);
  Route::get('statements/void', ['uses' => 'API\Statements@void']);
});

Route::group(['prefix' => 'xapi/v1', 'middleware' => 'auth.basic','auth.statement'], function () {
  Route::resource('statements', 'Mine\StatementsController'); 
});
