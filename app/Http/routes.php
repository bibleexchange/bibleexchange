<?php

/*
|--------------------------------------------------------------------------
| General Application Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/', function(){return Response::view('react');});

Route::get('/build-my-course', ['uses'   => 'BuildController@index']);
Route::get('/build-my-course/{filename}/publish', ['uses'   => 'BuildController@publish']);
Route::get('/build-my-course/{filename}/quiz-1', ['uses'   => 'BuildController@quiz']);

Route::get('/stream/{file}', function($file){

  $contents = file_get_contents(base_path().'/public/'.$file);
  $statusCode = 200;
  $response = Response::make($contents, $statusCode);
  $response->header('Content-Type', 'application/javascript');
  $response->header('Cache-Control', 'max-age: 99');
  return $response;
});

//Route::get('/course/{courseId}/edit', 'CourseEditController@edit');

Route::get('/course/{section}', function(){return view('react');})
  ->where(['section' => '.*']);

include(app_path().'/Http/routes/test.php');

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
Route::get('{section}', function(){return view('react');})
  ->where(['section' => '.*']);
