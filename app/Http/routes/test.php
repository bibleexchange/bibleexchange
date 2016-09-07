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

Route::get('test', function() {

var_dump(Auth::check());
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
