<?php namespace BibleExperience;

  use JWTAuth, Event;
  use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
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

class Viewer {

    use GlobalIdTrait;

   function __construct(){

     $this->error = new \stdClass();

	    try {
    		if (! $this->user = \JWTAuth::parseToken()->authenticate()) {
            $this->error->message= 'user_not_found';
            $this->error->code = 404;
            $this->user = User::getGuest();
    		}else{
          $this->error->message= 'Ok';
          $this->error->code = 200;
        }
	    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        $this->error->message= 'token_expired';
        $this->error->code = $e->getStatusCode();
        $this->user = User::getGuest();
	    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        $this->error->message= 'token_invalid';
        $this->error->code = $e->getStatusCode();
        $this->user = User::getGuest();
	    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        $this->error->message= 'token_absent';
        $this->error->code = $e->getStatusCode();
        $this->user = User::getGuest();
	    }
  }

  function bibles($args, $random = false){

  	$model = Bible::class;

  	switch($this->getCase($args, $random)){

  	  case 'filter':
  	    $collection = $model::search($args['filter']);
  	    break;

  	  case 'find':
  	    $decoded = $this->decodeGlobalId($args['id']);

      		if(is_array($decoded) && count($decoded) > 1){
      		  $collection = $model::find($decoded['id']);
      		}else{
      		  $collection = $model::find($args['id']);
      		}

  	    break;

  	  case 'random':
  		  $collection = $model::all();
  	    break;

  	  case 'all':
  		  $collection = $model::all();
  	    break;
  	}

  	return $collection;
  }

  function bibleBooks($args, $random = false){

  	$model = BibleBook::class;

  	switch($this->getCase($args,$random)){

  	  case 'filter':
  	    $collection = $model::search($args['filter']);
  	    break;

  	  case 'find':
  	    $decoded = $this->decodeGlobalId($args['id']);

  		if(is_array($decoded) && count($decoded) > 1){
  		  $collection = $model::find($decoded['id']);
  		}else{
  		  $collection = $model::find($args['id']);
  		}

  	    break;

  	  case 'random':
  		$collection = $model::all();
  	    break;

  	  case 'all':
  		$collection = $model::all();
  	    break;
  	}

  	return $collection;
  }

  function bibleChapters($args, $random = false){

	$model = BibleChapter::class;

	switch($this->getCase($args,$random)){

	  case 'filter':
	    $collection = BibleChapter::findChaptersByReference($args['filter']);
	    break;

	  case 'find':
	    $decoded = $this->decodeGlobalId($args['id']);

		if(is_array($decoded) && count($decoded) > 1){
		  $collection = $model::find($decoded['id']);
		}else{
		  $collection = $model::find($args['id']);
		}

	    break;

	  case 'random':
		$collection = $model::all();
	    break;

	  case 'all':
		$collection = $model::all();
	    break;
	}

	return $collection;
  }


  function bibleChapter($args, $random = false){

      if($random === "" || $random === false){

          $chapter = new BibleChapter;
         
      }else{

          $model = BibleChapter::class;

          switch($this->getCase($args,$random)){

            case 'filter':
              $chapter = BibleChapter::findChaptersByReference($args['filter'])[0];
              break;

            case 'find':
              $decoded = $this->decodeGlobalId($args['id']);

            if(is_array($decoded) && count($decoded) > 1){
              $chapter = $model::find($decoded['id']);
            }else{
              $chapter = $model::find($args['id']);
            }

              break;

            case 'random':
            $chapter = $model::random();
              break;

            case 'all':
            $chapter = null;
              break;
          }
      }

  return $chapter;
  }

  function bibleVerses($args, $random = false){

	$model = BibleVerse::class;

	switch($this->getCase($args,$random)){

	  case 'filter':
	    $collection = $model::findVersesByReference($args['filter']);
	    break;

	  case 'find':
	    $decoded = $this->decodeGlobalId($args['id']);

		if(is_array($decoded) && count($decoded) > 1){
		  $collection = $model::where('id',$decoded['id'])->get();
		}else{
		  $collection = $model::where('id',$args['id'])->get();
		}

	    break;

	  case 'random':
		$collection = $model::all();
	    break;

	  case 'all':
		$collection = $model::all();
	    break;
	}

	return $collection;
  }

 function bibleVerse($args, $random = false){

  $model = BibleVerse::class;

  switch($this->getCase($args,$random)){

    case 'filter':
      $verse = $model::findByReference($args['filter']);
      break;

    case 'find':
      $decoded = $this->decodeGlobalId($args['id']);

    if(is_array($decoded) && count($decoded) > 1){
      $verse = $model::where('id',$decoded['id'])->get();
    }else{
      $verse = $model::where('id',$args['id'])->get();
    }

      break;

    case 'random':
    //$collection = $model::all();
      break;

    case 'all':
    //$collection = $model::all();
      break;
  }

  return $verse;
  }


function crossReferences($args, $random = false){

      if($random === "" || $random === "undefined" || $random === null || $random === false){

          $collection = collect([]);
         
      }else{
        
         switch($this->getCase($args,$random)){

            case 'filter':
                $verse =  BibleVerse::findVersesByReference($args['filter'])->first();
                $collection = $verse->crossReferences;      
              break;

            case 'find':
              $model = CrossReference::class;
              $decoded = $this->decodeGlobalId($args['id']);

            if(is_array($decoded) && count($decoded) > 1){
              $collection = $model::where('id',$decoded['id'])->get();
            }else{
              $collection = $model::where('id',$args['id'])->get();
            }

              break;

            case 'random':
            $collection = $model::all();
              break;

            case 'all':
            $collection = $model::all();
              break;
          }


      }

  return $collection;
  }


  function libraries($args, $random = false){

  $model = Library::class;

  switch($this->getCase($args,$random)){

    case 'filter':
      $collection = $model::search($args['filter']);
      break;

    case 'find':
      $decoded = $this->decodeGlobalId($args['id']);

      if(is_array($decoded) && count($decoded) > 1){
        $collection = $model::find($decoded['id']);
      }else{
        $collection = $model::find($args['id']);
      }

      break;

    case 'random':
    $collection = $model::all();
      break;

    case 'all':
    $collection = $model::all();
      break;
  }

  return $collection;
  }

  function courses($args, $random = false){

  $model = Course::class;

  switch($this->getCase($args,$random)){

    case 'filter':
      $collection = $model::search($args['filter']);
      break;

    case 'find':
      $decoded = $this->decodeGlobalId($args['id']);

      if(is_array($decoded) && count($decoded) > 1){
        $collection = $model::where('id',$decoded['id'])->get();
      }else{
        $collection = $model::where('id',$args['id'])->get();
      }

      break;

    case 'random':
    $collection = $model::all();
      break;

    case 'all':
    $collection = $model::where('public',0)->get();
      break;
  }

  return $collection;
  }

  function lessons($args, $random = false){

  $model = Lesson::class;

  switch($this->getCase($args,$random)){

    case 'filter':
      $collection = $model::search($args['filter']);
      break;

    case 'find':
      $decoded = $this->decodeGlobalId($args['id']);

      if(is_array($decoded) && count($decoded) > 1){
        $collection = $model::where('id',$decoded['id'])->get();
      }else{
        $collection = $model::where('id',$args['id'])->get();
      }

      break;

    case 'random':
    $collection = $model::all();
      break;

    case 'all':
    $collection = $model::all();
      break;
  }

  return $collection;
  }

  function steps($args, $random = false){

  $model = Step::class;

  switch($this->getCase($args, $random)){

    case 'filter':
      $collection = $model::search($args['filter']);
      break;

    case 'find':
      $decoded = $this->decodeGlobalId($args['id']);

    if(is_array($decoded) && count($decoded) > 1){
      $collection = $model::find($decoded['id']);
    }else{
      $collection = $model::find($args['id']);
    }

      break;

    case 'random':
    $collection = $model::all();
      break;

    case 'all':
    $collection = $model::all();
      break;
  }

  return $collection;
  }

  function notes($args, $random = false){

    if(isset($args['user']) && $args['user'] === true){
      return $this->user->notes;
    }

    $model = Note::class;

    switch($this->getCase($args,$random)){

      case 'filter':
        $collection = $model::search($args['filter']);
        break;

      case 'find':
        $decoded = $this->decodeGlobalId($args['id']);
        $collection = $model::where('id',$decoded['id'])->get();
        break;

      case 'random':
        $collection = $model::all();
        break;

      case 'all':
        $collection = $model::all();
        break;
    }

    return $collection;
  }

  function getCase($args, $random){

    if(isset($args['filter'])){
  	  $case = 'filter';
  	}else if(isset($args['id'])){
  	  $case = 'find';
  	}else if($random == true){
  	  $case = 'random';
  	}else{
  	  $case = 'all';
  	}

  	return $case;
    }

  }
