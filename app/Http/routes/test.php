<?php

Route::get('/api/protected', ['middleware' => 'auth0.jwt', function() {
    return "Hello " . Auth0::jwtuser()->name;
}]);


/*
class QuizType {
  public __construct($instructions, $value){
    $this->type = 'quiz';
    $this->value = new \stdClass();
    $this->value->title = $title;
    $this->value->instructions = $instructions;
    $this->questions = $questions;
  }
}



class Item {

	public __construct($type, $value){
	  $this->type = $type;
	  $this->value = $value;
	}

}
*/

Route::get('/test', function() {

$notes = \BibleExperience\Note::search('ex 1:1');

dd($notes);
foreach($lesson->notes AS $note){
var_dump($note->pivot->next);
 // echo "<li>".$note->order_by . "  (uuid: " . $lesson->uuid . ") -- ".$note->output['type']."</li>";
 // echo "<div>".var_dump($note->output['value'])."</div>";
}

/*
$libraries = \BibleExperience\Library::all();

foreach($libraries AS $l){

echo "<div style='float:left; margin-left:50px; width:40%;'>";

 echo "<h1>LIBRARY: ".$l->title."</h1>";

echo "<h2>Courses</h2>";

 echo "<ul>";

	foreach($l->courses AS $course){

		echo "<hr><li>".$course->title . "  (uuid: " . $course->uuid . ")[".base64_decode($course->uuid)."]</li>";
		
		echo "<h3>----------" . $course->lessonsCount . "Lessons</h3>";

		echo "<ul>";

		foreach($course->lessons AS $lesson){
		  echo "<li>".$lesson->order_by . "  (uuid: " . $lesson->uuid . ") [".$lesson->stepsCount."]</li>";
			echo "<h4>Steps</h4>";
			echo "<ul>";

			foreach($lesson->steps AS $step){
			  echo "<li>".$step->order_by . "  (uuid: " . $lesson->uuid . ") -- ".$step->output['type']." ".$step->output['value']."</li>";
			}

			echo "</ul>";

		}

		echo "</ul>";

	}

 echo "</ul>";

echo "</div>";

}
*/
/*
$one = json_decode(file_get_contents(storage_path().'/uploads/1.txt'));
$one1 = json_decode(file_get_contents(storage_path().'/uploads/2.txt'));
$one2 = json_decode(file_get_contents(storage_path().'/uploads/3.txt'));
$one3 = json_decode(file_get_contents(storage_path().'/uploads/4.txt'));
$one4 = json_decode(file_get_contents(storage_path().'/uploads/5.txt'));
$one5 = json_decode(file_get_contents(storage_path().'/uploads/6.txt'));

$new = array_merge($one, $one1,  $one2, $one3, $one4, $one5);

$notes = [];
$fails = [];

foreach($new AS $r){

  $note = new \stdClass();
  $note->user_id = 1;
  $note->body = new \stdClass();
  $note->bible_verse_id = null;

  $note->body->tags = [];
  $note->body->links = [$r->permalink];
  $note->body->resourceUrl = $r->permalink_url;

  $note->body->resourceType = 'BibleExperience\Recording';

  $date = explode(' ',$r->title)[0];
  $note->body->text = $date . '[' . $r->permalink . ']' . $r->description .' ---- ';
$firstLetter = substr($date,0,1);

if($firstLetter == "0"){
	$date = "20" . $date;
}

  $rec = \BibleExperience\Recording::where('date','LIKE', strtoupper($date).'%')->get();

if(count($rec) < 1){
  var_dump(strtoupper($date));
  $fails[] = $r;
}else {

    foreach($rec AS $r){

      $note->body->links[] = 'http://deliverance.me/recordings/';

      if(!isset($note->body->resourceId)){$note->body->resourceId = $r->id;}
      foreach($r->verses AS $v){
          $note->bible_verse_id += '@' . $v->id;
      }

    }

}

$notes[] = $note;


}

print('<h1>FAIL COUNT: '.count($fails).'</h1>');

foreach($fails AS $f){
  print($f->permalink);
  print('<br>');
}

print('<h1>NOTES COUNT: '.count($notes).'</h1>');

foreach($notes AS $n){
  print($n->body->text);
 print('<strong>'.$n->body->resourceUrl.'</strong>');
  print('<br>');
}

///////////////////////////////////////////////////////////////////////////////////
print('#1 Is user logged in? ' . Auth::check() . "<br>");

//$title = "This is a Test Course";
$user = Auth::user();
$public = 1;
$bible_verse_id = 44001001;

//$course = \BibleExperience\Course::make($bible_verse_id, $title, $user->id, $public);
//$course->save();
$course = \BibleExperience\Course::find(58);

$title = "TEST New title";
$course->title = $title;
$course->save();

print('#2 Can I updated Course Title?' . $course->title . ' new title: ' . $title . "<br>");
/*
$step = \BibleExperience\Step::make($course->id, 2);
$step->save();
*/
/*
$order_by = 8;
$object_type_id = 8;
$object_id = 1;

$meta = new \stdClass();
$meta->description = "I test a lot";


$step = \BibleExperience\Step::find(30);
$attachment = \BibleExperience\StepAttachment::make($step->id, $order_by, $object_type_id, $object_id, json_encode($meta));
$attachment->save();
*/
/*
$rev = \BibleExperience\Revision::make("# Some Text for Testing", "md", $user->id);
$rev->save();

$text = \BibleExperience\Text::make($rev->id, 'none');
$text->save();

$text->edit("# Some Text for Testing", "md", $user->id);
*/
/*
print "<h1> TITLE: " . $course->title . "</h1>";
print "<p> DESCRIPTION: " . $course->description . "</p>";
print "<p> EDITOR: " . $course->owner->name . "</p>";

foreach($course->steps AS $step){

  print "<li>Step #".$step->order_by."</li>";

  foreach($step->attachments AS $att){

	print "<p> #" . $att->order_by . " " . $att->description ."</p>";
	print $att->type->classname;
	print "<p>";
	switch($att->object_type_id){
		case 1: //'\BibleExperience\Note':
			print $att->obj->body;
			break;
		case 2://\BibleExperience\BibleVerse
			print $att->obj->quote;
			break;
		case 3://\BibleExperience\Text
			print $att->obj->rawContent;
			print $att->obj->htmlContent;
			break;
		case 4://\BibleExperience\BibleChapter
			print "# of verses " . $att->obj->verseCount;
			break;
		case 5://\BibleExperience\BibleList
			print $att->obj->verses[0]->quote;
			print $att->obj->verses[1]->quote;
			print $att->obj->verses[2]->quote;
			break;
		case 6://\BibleExperience\Link
			print $att->obj->url;
			break;
		case 7://\BibleExperience\Recording
			print $att->obj->title;
			break;
		case 8://\BibleExperience\Image
			print $att->obj->url;
			break;
		case 9://\BibleExperience\Test
			print $att->obj->title;
			break;
	}
	print "</p>";
print "<hr />";
  }

}


/*
$q = new QuizType();

$quiz1 = new Item('quiz');

$step = \BibleExperience\Step::find(8);
dd($step->html);
*/
/*

"{"items": [{"type": "quiz","value": {"title": "Romans 1 Questions 1","instructions": "While reading Romans 1, answer the following questions.","questions": [{"question": "What was the reputation/testimony of the believers at Rome in verse 8?","type": "mc","options": [{"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "","correct": "0"}]}, {"question": "What did Paul think of these believers and what was the evidence of his sincerity in verses 8-9?","type": "mc","options": [{"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "","correct": "0"}]}, {"question": "What was Paul's request relating to the Romans in verse 10?","type": "mc","options": [{"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "In verses 10-12, Why did Paul make this request?","correct": "0"}, {"display": "","correct": "0"}]}, {"question": "In verses 13-15, Despite the obstacles Paul faced up to writing this letter, what was Paul still ready to do? ","type": "mc","options": [{"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "","correct": "0"}, {"display": "","correct": "0"}]}, {"question": "Paul was not sure if he wanted to visit Rome. TRUE or FALSE?","type": "mc","options": [{"display": "true","correct": "0"}, {"display": "false","correct": "1"}]}, {"type": "bible/chapters","value": ["1047"]}, {"type": "bible/memorize/verses","value": {"description": "Our first memory passage will be Romans 1:1,2 ( and for the especially eager Romans 1:1-7). When memorizing Scripture it is helpful to start with a shorter passage and then make it even shorter by breaking it down into pieces. Memorize the first five words in the verse first, and when you’ve got them down, add the next five. As you become more confident, you can add more words, sentences, and even entire verses, but don’t add anything new until you’ve got the previous words down. We will divide our passage into 6 lines for ease of putting to memory.","verses": ["45001001", "45001002"]}}, {"type": "quiz","value": {"title": "Romans 1:1-7 Questions","instructions": "","questions": [{"question": "Read Romans 1:1-7.","type": "read/bible/verses","options": ["45001001", "45001002", "45001003", "45001004", "45001005", "45001006", "45001007"]}, {"question": "Does any particular verse, phrase or even word stand out to you from this reading?","type": "subjective","options": []}, {"question": "What does Paul list as his main qualifications in verse 1?","type": "mc","options": [{"display": "Apostle","correct": "0"}, {"display": "Jew","correct": "0"}, {"display": "Servant","correct": "1"}, {"display": "Leader","correct": "0"}]}, {"question": "According to Paul in verses 2-6, who is Jesus?","type": "mc","options": [{"display": "Son of God","correct": "1"}, {"display": "King of Kings","correct": "0"}, {"display": "Prophet","correct": "0"}, {"display": "Messiah","correct": "0"}]}, {"question": "Who does Paul address this letter to in verse 7?","type": "mc","options": [{"display": "Unbelievers of the World","correct": "0"}, {"display": "Gentile Believers","correct": "0"}, {"display": "All Saints at Rome","correct": "1"}, {"display": "Timothy","correct": "0"}]}, {"question": "Complete the following scripture from memory.","type": "quote/verses","options": ["45001001", "45001002"]}, {"question": "What did you learn about yourself while memorizing Romans 1:1-2?","type": "subjective","options": []}]}}, {"type": "download/markdown","value": "https://raw.githubusercontent.com/bibleexchange/courses/master/book-of-romans/002_introduction-to-romans.md"}]}}]}"


*/
















  /*
  $recordings = \BibleExperience\RecordingVerse::skip(23000)->take(2000)->get();

  foreach($recordings AS $record){

	  $v = $record->verse;
	  $r = $record->recording;
	  $links = [];
	  $tags = "#" . str_replace(' ', '', $r->genre);

	  $text = '[recording] ' . $r->title.' - ';

	  foreach($r->persons AS $p){
		$name= $p->firstname .  " " . $p->lastname .  " " . $p->suffix;
		$role = $p->pivot->role;
		$text .= $role . ": ". $name . " ";

		$tags .= " #" . strtolower($p->lastname);

	  }

	  foreach($r->formats AS $f){

		switch($f->host){

			case 'soundcloud':
				$url = 'http://feeds-tmp.soundcloud.com/stream/' . $f->file;
				break;
			case 'local88888':
				$url = '';
				break;

			default:
				$url = "http:://deliverance.me/archive/recording/" . $r->id ."#" . $f->format;
		}
		$links[] = $url;
	  }

	  $text .= "recorded: " . $r->present()->datedNoTime;

	  $tags .= " #" . $r->present()->datedYear;
	  $tags .= " #deliverancecenter";
	  $tags .= " #be" . $v->id;

	  $noteBody = new MyNote($text, $tags, $links);

	  $note = new \BibleExperience\Note;
	  $note->body = json_encode($noteBody);
	  $note->user_id = 1;
	  $note->bible_verse_id = $record->verse_id;

	  $note->save();
  }
  */
});



/*
\Auth::logout();
$user = \BibleExperience\User::find(1);
$user->setPassword('me');
$user->save();
*/
