<?php

/*
|------------------------------------------------------------------
| Lrs & Lrs Client & Exporting & Reporting
|------------------------------------------------------------------
*/

Route::get('/lrs/list','RootController@index');


Route::get('lrs/{id}/statements', array(
  'uses' => 'LrsController@statements',
));
Route::get('lrs/{id}/users', array(
  'uses' => 'LrsController@users',
));
Route::get('lrs/{id}/stats/{segment?}', array(
  'uses' => 'LrsController@getStats',
));
Route::get('lrs/{id}/graphdata', array(
  'uses' => 'LrsController@getGraphData',
));
Route::put('lrs/{id}/users/remove', array(
  'uses' => 'LrsController@usersRemove',
  'as'   => 'lrs.remove'
));
Route::put('lrs/{id}/users/{user}/changeRole/{role}', array(
  'uses' => 'LrsController@changeRole',
  'as'   => 'lrs.changeRole'
));
Route::get('lrs/{id}/users/invite', array(
  'uses' => 'LrsController@inviteUsersForm',
));
Route::get('lrs/{id}/api', array(
  'uses' => 'LrsController@api',
));

Route::resource('lrs', 'LrsController');

/*
|------------------------------------------------------------------
| Exporting
|------------------------------------------------------------------
*/

// Pages.
Route::get('lrs/{id}/exporting', array(
  'uses' => 'ExportingController@index',
));

/*
|------------------------------------------------------------------
| Lrs client
|------------------------------------------------------------------
*/
Route::get('lrs/{id}/client/manage', array(
  'before' => 'auth',
  'uses' => 'ClientController@manage',
  'as' => 'client.manage'
));

Route::delete('lrs/{lrs_id}/client/{id}/destroy', array(
  'before' => 'auth',
  'uses' => 'ClientController@destroy',
  'as' => 'client.destroy'
));

Route::get('lrs/{lrs_id}/client/{id}/edit', array(
  'before' => 'auth',
  'uses' => 'ClientController@edit',
  'as' => 'client.edit'
));

Route::post('lrs/{id}/client/create', array(
  'before' => ['auth', 'csrf'],
  'uses' => 'ClientController@create',
  'as' => 'client.create'
));

Route::put('lrs/{lrs_id}/client/{id}/update', array(
  'before' => ['auth', 'csrf'],
  'uses' => 'ClientController@update',
  'as' => 'client.update'
));

/*
|------------------------------------------------------------------
| Reporting
|------------------------------------------------------------------
*/

//index and create pages
Route::get('lrs/{id}/reporting', array(
  'uses' => 'ReportingController@index',
  'as' => 'reporting.index'
));
Route::get('lrs/{id}/reporting/{report_id}/statements', array(
  'uses' => 'ReportingController@statements',
));
Route::get('lrs/{id}/reporting/typeahead/{segment}/{query}', array(
  'uses' => 'ReportingController@typeahead',
));
