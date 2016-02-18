<?php namespace BibleExchange\Helpers;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Cache;


class PreprocessText
{

function __construct()
	{
		$this->Str = new Strings();
	}

 public function lessonNotes($lessonId, $preview = false){
	
	$Chapter = Chapter::find($lessonId);
	
	$courseTitle = $this->Str->prettyName($Chapter->courses()->title);
	
	$one_textbook_path = app_path().'/assets/docs/'.$courseTitle;
	$one_textbook_file_dev = $one_textbook_path.'-dev.php';
	$one_textbook_file = $one_textbook_path.'.php';		
	$one_textbook_md = $one_textbook_path.'_md.php';
	
	if (file_exists($one_textbook_file_dev)) {
		$gdriveFileName = glob($one_textbook_path.'/'.$Chapter->id.'_*.*');
		if (is_array($gdriveFileName)){$gdriveFileName = $gdriveFileName[0];}
		$notes = $this->gdriveTest($gdriveFileName);
	}else if(file_exists($one_textbook_md)){		
		$markdownFileName = glob($one_textbook_path.'/'.$Chapter->id.'_*.md');
		if (is_array($markdownFileName)){$markdownFileName = $markdownFileName[0];}
		$notes = $this->markdownTest($markdownFileName, $courseTitle);
	}else if (file_exists($one_textbook_file)){
		$notes = $this->phpTest($one_textbook_file,$courseTitle,$Chapter->id);			
	}else {
		$base = $one_textbook_path.'/';
		$notes = $this->htmlNotes($base,$Chapter);
		}
	
	if (!$preview === false){
		return $this->getPreview($notes, $preview);
	} else {
		return $notes;
	}
 }
	
public function textbook($course_name)
{

$path = app_path().'/assets/docs/'.$course_name.'/';
$files = scandir($path);

foreach ($files AS $file){

if (substr($file,0,1) !='.'){
	$file = explode ('_',$file,2);
	$index = $file[0];
	$name = $file[1];

	$sections[$index] = [include($path.$index.'_'.$name)];
	}
}

return $sections;

}

public function getPreview($string,$length){
	if (is_string($string)){
		$string = preg_replace('#<[^>]+>#', ' ', $string);
		$string = substr($string, 0, $length);
	}
	return  $string;
}

public function getLessonsDropdown($courseId,$User){

$Course = Course::find($courseId);
$available = 0;
$dcounter = 0;
$Strings = new Strings();

$dropdown = '<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">'
    .Lang::ctrans('courses.'.$Course->title).
    '<span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
    
	foreach($Course->sections AS $section){
	
$dropdown .= '<li role="presentation" class="divider"></li>	
	<li role="presentation" class="dropdown-header">'.$section->title.'</li>';	
	
		foreach ($section->chapters AS $chapter){
				
				$progress = $chapter->progress;
				
				switch ($progress) {
				  case "correct":
					$glyphicon = '<span class="glyphicon glyphicon-ok"></span>';
					break;
				  case "wrong":
					$glyphicon = '<span class="glyphicon glyphicon-ban-circle"></span>';
					break;
				case "notgraded":
					$glyphicon = '<span class="glyphicon glyphicon-time"></span>';
					break;
				case "incomplete":
					$glyphicon = '<span class="glyphicon glyphicon-unchecked"></span>';
					break;
				  default:
				  $glyphicon = '';
				}

$dropdown .= '<li role="presentation">';

		$dropdown .= '<a href="/exchange'.$Strings->prettyName($Course->title).'/'.$Strings->prettyName($chapter['file_name']).'_'.$chapter['id'].'" class="';$dropdown .= $progress;
		$dropdown .= '" role="menuitem" tabindex="-1">'.$glyphicon.' Lesson '.$dcounter.': '.Lang::ctrans('chapterTitles.'.$chapter->file_name);
		$dropdown .= '</a></li>';
		$dcounter++;
		}
	}
   
 $dropdown .=  '</ul></div>';
  
  return $dropdown;

}


public function translate_textbook($course,$lang){

$notes = $this->textbook($course);

foreach ($notes AS $line){
	foreach ($line As $li){
		foreach ($li As $l){
			$k = $l[1];
			$v =$l[$lang];
			$array[$k] = $v;
		}
	}
}
return $array;
}

public static function translate_textbook_static($course,$lang){

$lesson = new Lesson();
return $lesson->translate_textbook($course,$lang);

}

   public function getGDoc($id){
	
	if (Cache::has($id))
	{    
		$content = Cache::get($id);
		
	} else {
			$path1 = 'https://docs.google.com/document/pub?id=';
			$content = file_get_contents($path1.$id);
				
			$start = strpos($content,'<div id="contents">');
			$end = strpos($content,'<div id="footer">');	

			$content = substr($content, $start, ($end-$start));

			$content = preg_replace('#(<style.*?>).*?(</style>)#', '$1$2', $content);
			
			$content = preg_replace("/<h([0-9])[^>]*?\>/i",'<h$1>', $content);
			
			$content = strip_tags($content,'<p><h1><h2><h3><h4><h5><h6><table><tr><td><th><img><hr>');
		
			$content = preg_replace('/<td[^>]*colspan="([0-9]*?)".rowspan="([0-9]*?)"[^>]*?\/?><h1>([^>]*?)\<\/h1>\<\/td>/im','<th colspan="$1" rowspan="$2"/>$3</th>',$content);
				
			$content = preg_replace('/<p [^>]*?subtitle"[^>]*?\>([^<]*?)\<\/p\>/i','<blockquote>$1</blockquote>', $content);
			
			$content = preg_replace('/<blockquote\>#([^>]*?)\<\/blockquote>/im','<blockquote class="quote">$1</blockquote>',$content);
			
			Cache::forever($id, $content);
		}		
		
		return $content;
	
   }

   public function htmlNotes($base,$Chapter){
   
    $notesPath = $base.$this->Str->prettyName($Chapter->file_name).'.html';
	
	if (file_exists($notesPath)){
		return file_get_contents($notesPath);
	}else{
		$notesPath2 = $base.$Chapter->id.'_'.$this->Str->prettyName($Chapter->file_name).'.'.$Chapter->file_type;
		return file_get_contents($notesPath2);
	}
   
   }
  
public function markdownTest($fileName,$courseTitle){
	
	$id = Lang::locale().'_'.$fileName;
	
	if (Cache::has($id) && App::environment() === 'production')
			{    
				return Cache::get($id);
				
			} else {
	$lines = file($fileName);
	$notes = '';
	
	foreach($lines As $line){	

		$insertBar = preg_replace('/^([^a-z0-9\<][#\>\-]*)([0-9a-z])/i', '$1|$2', $line);
		
		if (strpos($insertBar,'|') !== false) {
			$l = explode('|',$insertBar);
			
				if($l[0] === '>'){
					$collection = 'bible';
				}else{
					$collection = $courseTitle;
				}
			
			$translated = Lang::ctrans($collection.'.'.trim($l[1]));
			
			if (trim($l[0]) == '-'){
					$startTag = "- ";
				}else {
					$startTag = trim($l[0]);
				}
			
			$notes .= $startTag.$translated."\n";
		}else {
			$moreBars= trim(preg_replace('/^(\<[^>]*\>)([^<]*)(\<\/)/i', '$1|$2|$3', $insertBar));
			if (strpos($moreBars,'|') !== false) {
				
				$l = explode('|',$moreBars);				
				
				$notes .= trim($l[0]).Lang::ctrans($courseTitle.'.'.trim($l[1])).$l[2]."\n";
			}else if ($moreBars === ""){
				$notes .= "\n";
			}else if ( substr($moreBars, 0,1) !== "<"){
				$notes .= "\n".Lang::ctrans($courseTitle.'.'.$moreBars)."\n";
			}else {
				$notes .= $moreBars."\n";
			}
		}

	}
	$document = new MarkDown($notes);
	Cache::add($id, $document->render(),10080);

	$search = ['<p>@en</p>','<p>@sw</p>'];
	$replace = ['<div lang="en">','</div><div lang="sw">'];
	
	return str_replace($search,$replace,$document->render()).'</div>';
	}
}
 
public function markdown($lesson)
{
	
	$id = Lang::locale().'_'.$lesson->id.'_'.$lesson->slug;
	
	if (Cache::has($id) && \App::environment() === 'production')
		{    
			return Cache::get($id);
		} else {
			
			$md = new \Markdown;
			
			$document = $md->render($lesson->content);
			Cache::add($id, $document,720);
			return $document;
		}
}
 
public function gdriveTest($fileName){
		
		$gdriveId = file_get_contents($fileName);
		$notes1 = '<iframe src="https://docs.google.com/document/d/'.$gdriveId.'/pub?embedded=true"
		class="google-drive" frameborder="0" height="500px"></iframe>';
		
		$notes1 = $this->getGDoc($gdriveId);
		$edit_doc = '<a target="_blank" href="https://docs.google.com/a/deliverance.me/document/d/'.$gdriveId.'/edit" class="btn btn-primary">EDIT in GDrive <span class="glypicon glyphicon-pencil"></span></a>';
		$notes = new stdClass();
		$notes->edit = $edit_doc;
		$notes->text= $notes1;
		return $notes;
}

public function phpTest($file, $courseTitle,$lessonId){
	if (filesize($file) === 0){
		$Lesson = new Lesson();
		$textbook = $Lesson->textbook($courseTitle);
	
	}else {
		$textbook = include($file);
	}
	
	$notes1 = $textbook[$lessonId];
	$notes = '';
	foreach($notes1 As $line){	
		foreach ($line AS $l){
			$notes .= $l[0].Lang::trans($courseTitle.'.'.$l[1]).$l[3];
		}
	}
	return $notes;
}
 
}

?>