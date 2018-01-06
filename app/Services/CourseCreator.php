<?php namespace BibleExperience\Services;

use Illuminate\Support\Collection;
use stdClass, Str, View;
use BibleExperience\BibleBook as BibleBook;
use BibleExperience\BibleVerse as BibleVerse;
use BibleExperience\BibleReference;
use BibleExperience\Study as Study;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;

use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

class Step {

	function __construct($id, $file_name, $base_path, $course_name){

		$this->scripture = new stdClass;
		$this->scripture->pattern = "/(?:\d\s*)?[A-Z]?[a-z]+\s*\d+(?:[:-]\d+)+(?:\s*-\s*\d+)?(?::\d+|(?:\s*[A-Z]?[a-z]+\s*\d+:\d+))?/";
		$this->scripture->printPattern = "/<!-- scripture:[^>]*\-\->/";
		$this->includePattern = "/<!-- include:[^>]*\-\->/";
		$this->imagePattern = "/!\[[^\]]+\]\(([^\"]*) \"[^\)]*\"\)/"; //![Tabernacle Layout](tabernacle-layout.jpg "Tabernacle Layout")
		$this->id = $id;
		$this->meta = new stdClass;
		$this->meta->errors = [];
		$this->meta->courseName = $course_name;
		$this->type = "step";
		$this->file = new stdClass;
		$this->file->name = $file_name;
		$this->file->basePath = $base_path;
		$this->file->content = @file_get_contents($base_path .'/'.$file_name);
		$this->content = null;
		$this->activities = [];

		$this->getFiles()->convertScriptures()->fixImageLinks()->findReferences()->wordsData()->findActivities()->parseMarkdown();
	}

	function getFiles(){

		$this->content = preg_replace_callback(
		            $this->includePattern,
		           
				    function($match) {
				    
				    $clean = trim(str_replace("-->","",str_replace('<!-- include:', "",$match[0])));
				    $location = $this->file->basePath . "/".$clean;

				    $file = @file_get_contents($location);

				        if($file === false){
				        	$succesOrFail = false;
				        	$this->meta->errors[] = "File note found! : " . $location;
				        	return "File note found! : " . $location;
				        }else{
				        	$succesOrFail = true;
				        	return $file;
				        }

				        $this->meta->includes = ["file"=>$location, "where"=>$this->file->basePath . "/".$this->file->name, "success"=> $succesOrFail];

				    },
		            $this->file->content);

		return $this;
	}

	function convertScriptures(){

		$this->content = preg_replace_callback(
		            $this->scripture->printPattern,
		           
				    function($match) {
				        preg_match($this->scripture->pattern, $match[0], $reference);
						$ref = new BibleReference($reference[0]);
						$scripture = "> ";
	
						foreach($ref->versesInRange() AS $v){
							$scripture .= $v->order_by . " " . $v->body . " ";
						}
						
				        return $scripture;
				    },
		            $this->content);
		return $this;
	}

	function fixImageLinks(){

		$this->content = preg_replace_callback(
		            $this->imagePattern,
		           
				    function($match) {
				    	$url =  "http://localhost/bin/course-images/".$this->meta->courseName . "/" . $match[1];
				    	return str_replace($match[1], $url, $match[0]);


				    },
		            $this->content);

		return $this;
	}

	function findReferences(){
		preg_match_all($this->scripture->pattern, $this->content, $matches);
		$this->scripture->references = array_values(array_unique($matches[0]));
		$this->scripture->scripturesCount = count($matches[0]);
		return $this;
	}

	function wordsData(){

		$this->meta->charLength = strlen($this->content);
		
		$words = [];
		$words_array = str_word_count($this->content, 1);

		foreach($words_array AS $word){

			if(isset($words[strtolower($word)])){
				$words[strtolower($word)] = $words[strtolower($word)]+1;
			}else{
				$words[strtolower($word)] = 1;
			}
			
		}

		$filterOutKeys = ["and","And","the","The","span","of","Of","lang","to","p","a","A","it","is","are","mdash","quot","was","in","that",'a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero',"swa",'en','ya','wa','la','ni','id','class','--','na','cha','za','AD','BC'];

		$common = array_diff_ukey( $words, array_flip( $filterOutKeys ), 'strcasecmp' );

		arsort($common);
		$this->meta->wordsCount = count($words);
		$keyWords = array_slice($common,0,25);
		$k = [];
		foreach($keyWords AS $key=>$val){
			$x = new stdClass;
			$x->word = $key;
			$x->count = $val;
			$k[] = $x;
		}


		$this->meta->keyWords = $k;

		return $this;
	}


	public function findActivities(){

		$jsonPattern ="//";

		/*

<!-- {"type":"quiz", "content":{"title":"Introduction Questions","questions":[ { "question":"Who is the strongest?", "options":{ "a":"Superman", "b":"The Terminator", "c":"Waluigi, obviously" }, "answer":"c" }, { "question":"What is the best site ever created?", "options":{ "a":"SitePoint", "b":"Simple Steps Code", "c":"Trick question; they're both the best" }, "answer":"c" }, { "question":"Where is Waldo really?", "options":{ "a":"Antarctica", "b":"Exploring the Pacific Ocean", "c":"Sitting in a tree", "d":"Minding his own business, so stop asking" }, "answer":"d" } ]}} -->
		*/

		$this->content = preg_replace_callback(
		            $this->includePattern,
		           
				    function($match) {
				    
				    $clean = trim(str_replace("-->","",str_replace('<!-- include:', "",$match[0])));
				    $location = $this->file->basePath . "/".$clean;

				    $file = @file_get_contents($location);

				        if($file === false){
				        	$succesOrFail = false;
				        	$this->meta->errors[] = "File note found! : " . $location;
				        	return "File note found! : " . $location;
				        }else{
				        	$succesOrFail = true;
				        	return $file;
				        }

				        $this->meta->includes = ["file"=>$location, "where"=>$this->file->basePath . "/".$this->file->name, "success"=> $succesOrFail];

				    },
		            $this->file->content);

		return $this;

////////////////
        if(false/*l.substring(0,6) === "<!-- {"*/){
          //$ob = JSON.parse(l.replace("<!-- ","").replace("-->",""));
          //return <div key={i} >{that.processObject(ob, that.props.viewer)}</div>
        }else{
          //return <div key={i} dangerouslySetInnerHTML={{__html: l }}  />
        }

		return $this;
	}

public static function getDefinitionsBody($instructions = null)
  { 

    $body = null;

    $instructions = preg_replace("/@@[^@]*@@/m", "", $instructions);
    $pattern = "/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,8}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/";


      $NewText = preg_replace_callback("/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,8}\b([-a-zA-Z0-9@:%_\+.~#?&\/=]*)/", function($Match){

          $url = explode('|',$Match[0]);

          $x = null;

          if(isset($url[1])){
            $x = self::urlParser($url[0],json_decode($url[1]))->html;
          }else{
            $x = self::urlParser($url[0],null)->html;
          }
         
            return $x;

    }, $instructions);

       return Markdown::convertToHtml($NewText);

  }

   public static function urlParser($url, $instructions = null)
  { 

    $parser = new stdClass;
    $parser->type = 'STRING';
    $parser->instructions = new stdClass;
    $parser->api_request = new stdClass;

    if($instructions === null || $instructions === ""){
      $parser->instructions->value = new stdClass;
      $parser->instructions->api = false;
    }else{
      $parser->instructions->value = $instructions;

      if(!isset($parser->instructions->api)){

        $parser->instructions->api = false;
      }
    }

    $parser->url = $url;

    preg_match('/^(https?:\/\/)?(ftp:\/\/)??(file:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,8})?/', $url, $domain);

    $x = explode('://',$domain[0]);

    $parser->protocol = $x[0];
    $parser->domain = $x[1];
    $parser->id = str_replace($domain[0] . '/', "", $url);

    switch($parser->domain){

      case 'definitions.bible.exchange':

          $d = self::getDefinitionsBody($parser->id, $parser->instructions->value);
          $parser->body = $d->body;
          $parser->type = $d->type;

      break;

      case 'bible.exchange':

          $be = self::getBibleExchangeBody($parser->id, $parser->instructions->value);
          $parser->body = $be->body;
          $parser->type = $be->type;
          $parser->html = $be->html;

      break;

      case 'raw.githubusercontent.com':

            $response = self::getRawFromUrl($url);

            if($response[0] === "SUCCESS"){
               
               $parser->body = $response[1];
               $parser->html = Markdown::convertToHtml($response[1]);
             }else{

              $parser->body = null;
              $parser->html = null;

             }

      break;

      case 'youtube.com':
      case 'www.youtube.com':
        $parser->id = str_replace("watch?v=","",$parser->id);
      case 'youtu.be':
        $parser->type = 'YOUTUBE_API';
        $youtube_api_key = env('YOUTUBE_API_KEY');
        $youtube_api_url = "https://content.googleapis.com/youtube/v3/search?maxResults=1&part=snippet&q=".$parser->id."&type=video&key=" . $youtube_api_key;
        
        $parser->html =  '<iframe width="100%" style="min-height:250px;" src="https://www.youtube.com/embed/'.$parser->id.'" frameborder="0" allowfullscreen></iframe>';
        $parser->body = self::getRawFromUrl($youtube_api_url);  
        break;
      
      case 'soundcloud.com':
      case 'feeds-tmp.soundcloud.com':
      case 'api.soundcloud.com':
        $parser->type = 'STRING';    

        $id =  explode('/',$parser->id);

        if($id[0] === "tracks" || $id[0] === "stream"){
          $parser->html =  '<iframe width="100%" height="200" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'.$id[1].'&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';
        }else{
          $parser->html =  '<iframe width="100%" height="200" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$parser->url.'&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true"></iframe>';;
        }

        $parser->body = json_decode('{}'); 

      break;

      default:
        $parser->body = $instructions;
        $parser->html = "<a href='" . $parser->url . "'>".$parser->url."</a>";
      }

    return $parser;

  }

public function transformQuiz($el, $baseRef)
	{
	  $newObj = $el;
	  $x = 0;

	  foreach($el->questions AS $q){

		switch($q->type){
		  case 'bible/chapters':
			foreach($q->value AS $ch){
			  foreach(\BibleExperience\BibleChapter::find((int)$ch)->verses AS $v){
				$verses[] = $v->quoteRelative($baseRef);
			  }
			}
			$newObj->questions[$x] = $verses;
			break;
		  case 'bible/memorize/verses':

			break;
		  case 'read/bible/verses':
		  	foreach($q->options AS $v){
				$verse = \BibleExperience\BibleVerse::find((int)$v);
				$verses[] = $verse;
			  }
			$questions = $verses;
			break;

		}
		$x++;
	  }

		return $newObj;
	}

		public static function getRawFromUrl($url)
	{
	  $string = @file_get_contents($url);

		if(!$string){
		  return ['FAIL',$url];
		}else{
		  return ['SUCCESS',$string];
		}

	}

	//Not sure if following function is even used anywhere


    public static function getBibleExchangeBody($id, $instructions = null)
  { 

    $be = new stdClass;
    $be->type = null;
    $be->body = new stdClass;

    $id_array = explode('/',$id);


    switch($id_array[0]){

      case 'bible':
        $be->type = "BIBLE_REFERENCE";
        $ref_object = new BibleReference($id_array[1]);
        $ref_object->reference = $ref_object->input->string;
        $ref_object->verses = [];
        $html = '';

          foreach($ref_object->versesInRange() AS $v){

            $verse = new stdClass;
            $verse->id = $v->id;
            $verse->order_by= $v->order_by;
            $verse->body = $v->body;
            $verse->url =  $v->url;
            $verse->reference =  $v->reference;

            $ref_object->verses[] = $verse;
            $html .= $v->quote;
          }

          $be->body = $ref_object; 
          $be->html = $html;

      break;

      case 'notes':    
        $be->type = "NOTE";
        $id = explode(":",base64_decode($id_array[1]))[1];
        $note = Note::find($id);
        $be->body = $note;
        $be->html = null;

      break;

      case 'courses':
        $be->type = "Course";
        $be->body = Course::find($id);
        $be->html = null;
      break;


      default:
        $be->type = null;
        $be->body = new stdClass;
      }
    
    return $be;

  }

  public function parseMarkdown(){
  			// Obtain a pre-configured Environment with all the CommonMark parsers/renderers ready-to-go
		$environment = Environment::createCommonMarkEnvironment();

		// Optional: Add your own parsers, renderers, extensions, etc. (if desired)
		// For example:  $environment->addInlineParser(new TwitterHandleParser());

		// Define your configuration:
		$config = [];

		// Create the converter
		$converter = new CommonMarkConverter($config, $environment);

		// Let's render it!
		$this->content = $converter->convertToHtml($this->content);

		return $this;
  }


}

class Section {

	function __construct($id, $line){
		$this->id = $id;
		$this->type = "section";
		$this->title = substr($line, 2);
		$this->steps = [];
	}

}

class CourseCreator {

function __construct($course_name){
		
		$this->delimeters = [
			"title"=>"# ",
			"reference"=>"> ",
			""=>""
		];

		$this->meta = new stdClass;
		$this->meta->errors = [];
		$this->scripture = new stdClass;
		$this->scripture->references = [];
		$this->scripture->scripturesCount = 0;
		$this->sections = [];
		$this->meta->keyWords = [];
		$this->meta->name = $course_name;
		$this->base_path = base_path().'/../courses/' . $course_name;
		
		$this->initialize()->setSteps();

	}

	function __toString(){
		return json_encode($this);
	}

	function initialize(){
		$config =  @file_get_contents($this->base_path . "/index.md");
		$lines = explode(PHP_EOL,$config);
		$secId = 0;

		foreach($lines AS $line){

			if(substr($line, 0,2) === "- "){//Sections
				$stepId = 0;
				$this->sections[$secId] = new Section($secId, $line);
				$secId++;
			}else if(substr($line, 0,4) === "  * "){//Steps
				$this->sections[$secId-1]->steps[$stepId] = new Step($stepId, trim(substr($line,4)), $this->base_path, $this->meta->name);
				$stepId++;
			}else {//Meta
				$this->computeMetaData($line);
			}

		}

		return $this;
	}

	function setSteps(){
		$this->steps = [];

		

		foreach($this->sections AS $sec){		
				foreach($sec->steps AS $step){
					$this->scripture->references = array_merge($this->scripture->references, $step->scripture->references);
					$this->scripture->scripturesCount = $this->scripture->scripturesCount + $step->scripture->scripturesCount;

					$this->steps[] = $step; 
				}
		}

		return $this;

	}

	function computeMetaData($line){
		$meta = explode(":",$line,2);

		if(!isset($meta[1])){

		}else {

			$key = trim(strtolower($meta[0]));
			$value = trim($meta[1]);

			if($key === "tags" || $key === "editors"){
				$this->meta->$key = array_map('trim', explode(',',$value));
			}else if($key === "scripture"){
				$this->meta->scripture = $value;
				$this->scripture->main = $value;
			} else {
				$this->meta->$key = $value;
			}
		}
	}

  function toJSON(){
  	return $this;
  }


}