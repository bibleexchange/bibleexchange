<?php
//dd($random = rand (1, 1024));
/*
|--------------------------------------------------------------------------
| General Application Routes
|--------------------------------------------------------------------------
|
*/
include(app_path().'/Http/routes/test.php');

Route::get('/stream/{file}', function($file){

  $contents = file_get_contents(base_path().'/public/'.$file);
  $statusCode = 200;
  $response = Response::make($contents, $statusCode);
  $response->header('Content-Type', 'application/javascript');
  $response->header('Cache-Control', 'max-age: 99');
  return $response;
});


/*
|--------------------------------------------------------------------------
| Graphiql
|--------------------------------------------------------------------------
|
*/
Route::get('graphiql',function(){return view('graphiql');});

include(app_path().'/Relay/Http/routes.php');
/*
|------------------------------------------------------------------
| Site (this is for super admin users only)
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/site.php');

/*
|------------------------------------------------------------------
| Lrs & Lrs Client & Exporting & Reporting
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/lrs.php');

/*
|------------------------------------------------------------------
| Statements
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/statements.php');

/*
|------------------------------------------------------------------
| Learning Locker RESTful API
|------------------------------------------------------------------
*/
include(app_path().'/Http/routes/api-v1.php');

/*
|----------------------------------------------------------------------
| Auth handling
|----------------------------------------------------------------------
*/
include(app_path().'/Http/routes/auth.php');

//CATCH ALL ROUTE

Route::get('/notes/{noteId}', '\BibleExperience\Http\Controllers\ReactController@note');
Route::get('/course/{courseId}', '\BibleExperience\Http\Controllers\ReactController@course');
Route::get('/bible/{reference}', '\BibleExperience\Http\Controllers\ReactController@bible');
Route::get('{section}', '\BibleExperience\Http\Controllers\ReactController@index')->where(['section' => '.*']);
