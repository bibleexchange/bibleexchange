<?php namespace BibleExperience;

use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\PaginatedCollection;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\User;
use BibleExperience\Bible;
use BibleExperience\BibleBook;
use BibleExperience\BibleChapter;
use BibleExperience\BibleVerse;
use BibleExperience\Library;
use BibleExperience\Course;
use BibleExperience\CrossReference;
use BibleExperience\Lesson;
use BibleExperience\Step;
use BibleExperience\Note;
use BibleExperience\Search;
use BibleExperience\Track;

use stdClass;

class Viewer {

   function __construct($auth){

     $this->id = $auth->token;
     $this->name = $auth->user->name;
     $this->email = $auth->user->email;
     $this->verified = $auth->user->verified;
     $this->role = $auth->user->role;
     $this->password = $auth->user->password;
     $this->remember_token = $auth->user->remember_token;
     $this->nickname = $auth->user->nickname;
     $this->url = $auth->user->url;
     $this->lastStep = $auth->user->lastStep;
     $this->authenticated = $auth->user->authenticated;
     
     $this->lang = 'ENGLISH';

     $this->user = $auth->user;
     $this->error = $auth->error;
     $this->token = $auth->token;
  
  }

  function one($args, $model){
    $id = GraphQLGenerator::decodeId($args['id']);

    if (isset($model[5])){
      $model = $model[3];
      return $this->user->$model()->where($model . '.id', $id)->first();
    }else{
      $model = $model[4];

      switch($model){
        case 'BibleExperience\\BibleVerse':
          $verse = $model::find($id);

          if($verse === null){
            $verse = $model::findByReference($args['id']);
          }

          return $verse;
          break; 

       case 'BibleExperience\\BibleChapter':
          return $model::findByReference($args['id']);
          break;    

        default:
          return $model::find($id);

      }
    
    }
  }

  function many($args, $model){

    if (isset($model[5])){
      $model = $model[3];
      

      switch($model){
        case 'notes':
         
          return  new PaginatedCollection($args, $this->user->$model()->orderBy('updated_at','DESC'));
          break;  

        default:
          return new PaginatedCollection($args, $this->user->$model());

      }
    }else{
      $model = $model[4];
      return new PaginatedCollection($args, new $model);
    }
 
  }

  function getAuthorizedUser($args){
    return $this->user;
  }

  function setLang($lang){
    $this->lang = $lang;
    return $this;
  }

}

