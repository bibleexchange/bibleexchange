<?php

/*
|------------------------------------------------------------------
| Temporary Routes for Testing and Development Purposes
|------------------------------------------------------------------
*/


Route::get('/temp1', function(){

//dd(base64_decode("YXJyYXljb25uZWN0aW9uOjA"), , "YXJyYXljb25uZWN0aW9uOjA");

$v = \BibleExperience\BibleVerse::findByReference("mark 7:2");//23515
dd($v->id);

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