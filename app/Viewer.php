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
    use BibleExperience\Search;

class Viewer {

    public $token;
    public $myNotes;

    use GlobalIdTrait;

   function __construct($auth){
     $this->user = $auth->user;
     $this->myNotes = $auth->myNotes;
     $this->error = $auth->error;
     $this->token = $auth->token;
  }

  public static function search($args, $random = false){
    return new Search($args);
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

      if(empty($args)){

          $chapter = new BibleChapter;

      }else{

          $model = BibleChapter::class;

          switch($this->getCase($args,$random)){

            case 'filter':
              $chapter = BibleChapter::findByReference($args['filter']);
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
      $verse = new $model;
      break;
  }

  return $verse;
  }


function crossReferences($args, $random = false){

      if(empty($args)){

          $collection = collect([]);

      }else{

         switch($this->getCase($args,$random)){

            case 'filter':
                $verse =  BibleVerse::findByReference($args['filter']);
                if($verse !== null){
                  $collection = $verse->crossReferences;
                }else{
                  $collection = collect([]);
                }

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
              $collection = collect([]);
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
    $collection = $model::where('public',1)->get();
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

    function getMyNotes($args, $random = false){
          $model = Note::class;

    switch($this->getCase($args,$random)){

      case 'filter':

        $collection = $model::where('user_id',$this->user->id)->where('tags_string','LIKE','%'.$args['filter'].'%')->get();
      break;

      case 'find':
        $decoded = $this->decodeGlobalId($args['id']);
        $collection = $model::where('id',$decoded['id'])->get();
        break;

      case 'random':
        $collection = $this->myNotes;
        break;

      case 'all':
        $collection = $this->myNotes;
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
