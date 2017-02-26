<?php namespace BibleExperience\Build;

use BibleExperience\BibleVerse;
use BibleExperience\Note;
use BibleExperience\Build\Quiz;
use Markdown, stdclass;

class Course {
	function __construct($json_string){
		$this->data = json_decode($json_string);

		$this->title = null;
		$this->name = null;
		$this->image = null;
		$this->description = null;
		$this->keywords = [];
		$this->author = null;
		$this->sections = [];

		$this->initialize();

	}

	function initialize(){
		$this->setTitle()->setName()->setImage()->setDescription()->setKeywords()->setAuthor()->setSections();
	}

	function setTitle(){
		if(isset($this->data->title)){
			$this->title = $this->data->title;
		}
		return $this;
	}

	function setName(){
		if(isset($this->data->name)){
			$this->name = $this->data->name;
		}
		return $this;
	}

	function setDescription(){
		if(isset($this->data->description)){
			$this->description = $this->data->description;
		}
		return $this;
	}

	function setImage(){
		if(isset($this->data->image)){
			$this->image = $this->data->image;
		}else{
			$this->image = "https://bible.exchange/assets/img/be_logo.png";
		}
		return $this;
	}

	function setKeywords(){
		if(isset($this->data->keywords)){
			$this->keywords = $this->data->keywords;
		}
		return $this;
	}

	function setAuthor(){
		if(isset($this->data->author)){
			$this->author = $this->data->author;
		}
		return $this;
	}

	function setSections(){

		if(isset($this->data->sections)){
			$this->sections = $this->data->sections;
		}
		return $this;
	}

	function getMediaHTMLString($type, $id){
		$html = '';

		switch($type){

			case "NOTE":
			  $html = $id;

				$note = Note::find($id);

				if(isset($note->output)){
					$html = $this->getNoteHTML($note->output);
				}

				break;
			case "BIBLE":
			  $html = "";
				$verses = BibleVerse::findVersesByReference($id);
				foreach($verses AS $v){
					$html = $html . $v->quote;
				}
				break;

			case "STRING":
			  $html = $id;
				break;

			case "MARKDOWN":
				$html = Markdown::convertToHtml($id);
				break;

			case "YOUTUBE":
				$html = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $id . '?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
				break;

			case "QUIZ":
				$html = $this->getQuizHTML($id);
				break;

      case "RAW_FROM_URL":
				$html = $this->getFile($id);
				break;

			default:
				$html = '<p>&nbsp;</p>';
		}

		return $html;

	}
function getFile($url){
	$file_name = str_replace('https://raw.githubusercontent.com/bibleexchange/courses/master/', '', $url);
	$file_name = resource_path() . '/../../courses/' . $file_name ;
	if(file_exists($file_name)){

		$html = file_get_contents($file_name);
		$file_parts = pathinfo($file_name);

		switch($file_parts['extension'])
			{
			    case "md":
						//$html = Markdown::convertToHtml($html);
			    	break;

			    case "exe":
			    break;

			    case "": // Handle file extension for files ending in '.'
			    case NULL: // Handle no file extension
			    break;
			}

			return $html;
	}

	$contents = @file_get_contents($id);
	if(!$contents){
		return '<h2 style="color:red;">'.$url.' could not be found!</h2>';
	}else{
		$dirname = dirname($file_name);
		if (!is_dir($dirname))
		{
				mkdir($dirname, 0755, true);
		}
		$file = fopen($file_name,"w");
		echo fwrite($file,$contents);
		fclose($file);

		return $contents;
	}

}
	function getNoteHTML($noteCache){

		$html = '';

		switch($noteCache->type){

			case "MARKDOWN":
				$html = Markdown::convertToHtml($noteCache->body);
				break;
			case "BIBLE":


				break;
			case "STRING":

			default:
				$html = '<p>&nbsp;</p>';
		}

		return $html;

	}

	function getQuizHTML($data){
		$quiz = new Quiz($data);

		$html = "<h1>" . $quiz->title . "</h1><p>Instructions: " . $quiz->instructions . "</p><ul>";

		  foreach($quiz->questions AS $que){

			$html .= "<li><p>" . $que->body . "</p><p>" . $que->activity . "</p></li>";
		}

		$html .= "</ul>";
		return $html;
	}

}
