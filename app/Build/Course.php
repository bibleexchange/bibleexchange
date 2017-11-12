<?php namespace BibleExperience\Build;

use Illuminate\Support\Facades\URL;
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
		$this->trans = false;
		$this->initialize();

	}

	function initialize(){
		$this->setTitle()->setName()->setImage()->setDescription()->setKeywords()->setAuthor()->setSections()->setTrans();
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

			if(file_exists(base_path() . "/../public_html/assets/img/tiles/" . $this->name . ".jpg")){
				$this->image = URL::to("/assets/img/tiles/" . $this->name . ".jpg");
			}else{
				$this->image = "https://bible.exchange/assets/img/be_logo.png";
			}


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

	function setTrans(){

				if(isset($this->data->trans)){
					$this->trans = $this->data->trans;
				}
				return $this;
	}

	function getMediaHTMLString($type, $id){

		switch($type){

      case "FILE":
					$output = self::getStepHTML($this->getFile($id));
				break;

			case "TRANSLATION":
				$output =  utf8_encode($this->getFile($id));
				break;

			case "JSON":

				$file_name = str_replace('https://raw.githubusercontent.com/bibleexchange/courses/master/', '', $id);
				$file_name = resource_path() . '/../../courses/' . $file_name ;
				if(file_exists($file_name)){

					$output = file_get_contents($file_name);

			}

				break;

			default:
				$output = '<p>&nbsp;</p>';
		}

		return $output;

	}
function getFile($url){
	$file_name = str_replace('https://raw.githubusercontent.com/bibleexchange/courses/master/', '', $url);
	$file_name = resource_path() . '/../../courses/' . $file_name ;
	if(file_exists($file_name)){

		$html = file_get_contents($file_name);
		$file_parts = pathinfo($file_name);

		if(array_key_exists("extension",$file_parts) === false){
			$extension = "md";
		}else{
			$extension = $file_parts['extension'];
		}

		switch($extension)
			{
			    case "md":
						//$html = Markdown::convertToHtml($html);
			    	break;

			    case "json":
						$html = file_get_contents($html->id);
						//$html = json_decode($html);
						//$html = $this->getMediaHTMLString($html->type, $html->id);
			    break;

			    case "": // Handle file extension for files ending in '.'
			    case NULL: // Handle no file extension
			    break;
			}

			return $html;
	}else{

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

	static function getStepHTML($raw_from_file){

		$exploded = explode(PHP_EOL, $raw_from_file);
		$list = [];


		foreach ($exploded AS $line){

			$x = new stdClass;
			$x->type = null;
			$x->string = null;

			if(substr($line, 0,1) === "{"){

				$x->type = 'JSON';
				$x->string = $line;

				$list[] = $x;
			}else if($line !== ""){
				$string =  utf8_encode(Markdown::convertToHtml($line));

			if(substr($line, 0,1) === "{"){
				//left off here !!!!!
				$string .= $line;
			}else{
				$string .= Markdown::convertToHtml($line);
				$x->type = 'HTML';
				$x->string = $string;

				$list[] = $x;
			}
		}

		return $list;
	}

}
