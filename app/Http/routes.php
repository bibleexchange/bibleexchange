<?php

/*
|--------------------------------------------------------------------------
| General Application Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/', function(){return Response::view('react');});

Route::get('/temp1', function(){
$notes = \BibleExperience\Note::take(10)->skip(0)->get();
$n = null;

foreach($notes AS $note){

  if($note->body === $n){
    $n = $note->body;
  }else{
    echo $note->id . "   ". $note->body . '<br />';
  }


}

});

Route::get('/temp99999', function(){
  //$dir = scandir(base_path() . '/../courses/cults');
  $number = 0;

  foreach($dir AS $file){
    if(strpos($file, '.') !== (int) 0){
      $number++;
      $new_file_string = '';
      $x = include(base_path() . '/../courses/cults/'.$file);

      foreach($x AS $y){
          $new_file_string .= $y[0].$y[2].$y[3];
      }

      $name = explode('_',str_replace('.php', '', $file));
      $myfile = fopen(base_path() . '/../courses/translations/cults/swa/' . sprintf("%03d", $number) .'_' . $name[1] . ".md", "w") or die("Unable to open file!");
      $txt = $new_file_string;
      fwrite($myfile, $txt);
      fclose($myfile);
    }

  }

});

Route::get('/temp', function(){
  //$dir = scandir(base_path() . '/../courses/cults');
  $number = 0;

  foreach($dir AS $file){
    if(strpos($file, '.') !== (int) 0){
      $number++;


      $name = explode('_',str_replace('.php', '', $file));
      $translation_name = sprintf("%03d", $number) .'_' . $name[1] . ".md";

      echo '"'.$file.'": [{
        "lang": "swa",
        "file": "'.$translation_name.'"
      }],';

    }

  }

});




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
