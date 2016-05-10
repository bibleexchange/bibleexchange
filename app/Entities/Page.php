<?php namespace BibleExchange\Entities;

use BibleExchange\Core\PresentableTrait;

class Page {
	
	public $api;
	public $author; 
	public $categories;
	public $description;
	public $existsInDb = false;
	public $history;
	public $mainImage;
	public $routes;
	public $section;
	public $tags;
	public $title;
	public $type;
	public $website;
	
	public $created_at;
	public $updated_at;
	
	use PresentableTrait;
	protected $presenter = 'BibleExchange\Presenters\PagePresenter';
	
	public function __construct(){
		$this->api = new \stdClass();
		$this->author = new \stdClass();
	}

	/* Setter Functions */
	
	public function setApi(){
		
		$this->api->facebookAppId = '1529479753993292';
		
		return $this;
	}
	
	public function setAuthor($author)
	{
		
		$this->author->contact = $author->contact;//array
		$this->author->name = $author->name;
		
		return $this;
		
	} 
	public function setCategories($categories){
		
		$this->categories = $categories;
		
		return $this;
	}
	
	public function setDescription($description){
	
		$this->description = $description;
	
		return $this;
	}
	
	public function setExists($exists = false){

		$this->existsInDb = $exists;

		return $this;
	}
	
	public function setHistory(array $history){
		//published, created, modified, versions
		$this->history = $history;
		
		return $this;
		
	}
	public function setMainImage($mainImage){

		$this->mainImage = $mainImage;
		
		return $this;
		
	}
	public function setRoutes($routes){

		$this->routes = $routes;
		
		return $this;
		
	} //main + sharing url
	public function setSection($section = 'Study'){

		$this->section = $section;
		
		return $this;
		
	}
	
	public function setTags($tags){
	
		$this->tags = $tags;
	
		return $this;
	}
	
	public function setCreatedAt($timestamp = null){
	
		$this->created_at = $timestamp;
	
		return $this;
	}
	
	public function setUpdatedAt($timestamp = null){
	
		$this->updated_at = $timestamp;
	
		return $this;
	}
	
	public function setTitle($title){
	
		$this->title = $title;
	
		return $this;
	}
	
	public function setType($type){
		
		$this->type = $type;
		
		return $this;
		
	}
	
	public function setWebsite($website = 'http://bible.exchange'){
		
		$this->website = $website;
		
		return $this;
		
	}
	
	public function make($object){
		
		switch(get_class($object)){
			
			case 'BibleExchange\Entities\Course':
				$object = $this->mapCourse($object);
				break;
			case 'BibleExchange\Entities\Recording':
				$object = $this->mapRecording($object);
				break;
			case 'BibleExchange\Entities\Note':
				$object = $this->mapNote($object);
				break;
			case 'BibleExchange\Entities\User':
				$object = $this->mapUser($object);
				break;
			case 'BibleExchange\Entities\Study':
				
				if($object->exists){
					$object =  $this->mapStudy($object);
				}else{
					$object = $this->mapMissing($object);
				}
				
				break;
			
			default:
				die;
		}
		
		$this->setApi()
			->setAuthor($object->author) //name(s) // contact info like twitter handle
			->setCategories($object->categories)
			->setCreatedAt($object->created_at)
			->setDescription($object->description)
			->setHistory($object->history) //published, created, modified, versions
			->setMainImage($object->mainImage)
			->setRoutes($object->routes) //default url + current url + sharing url
			->setSection($object->section)
			->setTags($object->tags)
			->setTitle($object->title)
			->setType($object->type)
			->setUpdatedAt($object->updated_at)
			->setWebsite($object->url)
			->setExists($object->exists);
		
		return $this;
	
	}
	
	/*Map different Kinds of Pages*/
	
	private function mapUser($user){
	
		$page = new \stdClass();
	
		$page->title = $user->present()->fullname;
		$page->description = $user->firstname . ' has been a Bible exchange member since ' . $user->joined();
	
		$author = $user;
	
		$authorRefactored = new \stdClass();
		$authorRefactored->contact = ['twitter'=>$author->twitter];
		$authorRefactored->name = ['profile'=>'@'.$author->username,'firstname'=> $author->firstname, 'lastname'=>$author->lastname, 'fullname'=> $author->fullname];
	
		$page->author = $authorRefactored;
		$page->categories = 'Amens';
		$page->exists = $user->exists;
		$page->history = ['created'=>$user->created_at,'published' => $user->created_at,'modified'=> $user->updated_at, "version"=> $user->updated_at];
		$page->mainImage = $user->image;
		$page->routes = ['default_url'=>$user->url, 'sharing_url'=>$user->url];
		$page->section = 'Amens';
		$page->tags = $user->present()->tagsAsString;
		$page->type = 'Amens';
	
		$page->updated_at = $user->updated_at;
		$page->created_at = $user->created_at;
	
		$page->url = $user->url;
		
		return $page;
	}
	
	private function mapNote($note){

		$page = new \stdClass();
		
		$page->title = $note->present()->title;
		$page->description = 'Bible Note on '.$note->verse->reference.'created by @'. $note->user->username;
		
		$author = $note->user;
		
		$authorRefactored = new \stdClass();
		$authorRefactored->contact = ['twitter'=>$author->twitter];
		$authorRefactored->name = ['profile'=>'@'.$author->username,'firstname'=> $author->firstname, 'lastname'=>$author->lastname, 'fullname'=> $author->fullname];
		
		$page->author = $authorRefactored;
		$page->categories = 'Bible Notes';
		$page->exists = $note->exists;
		$page->history = ['created'=>$note->created_at,'published' => $note->created_at,'modified'=> $note->updated_at, "version"=> $note->updated_at];
		$page->mainImage = $note->image;
		$page->routes = ['default_url'=>$note->url(), 'sharing_url'=>$note->url()];
		$page->section = 'Bible Notes';
		$page->tags = $note->present()->tagsAsString;
		$page->type = 'Bible Note';
		
		$page->updated_at = $note->updated_at;
		$page->created_at = $note->created_at;
		
		$page->url = $note->url();
		return $page;
	}
	
	private function mapStudy($studyModel){
	
		$study = new \stdClass();
	
		$study->title = $studyModel->present()->title;
		$study->description = $studyModel->description;
		//$study->api =

		$author = $studyModel->creator;
		
		$authorRefactored = new \stdClass();
		$authorRefactored->contact = ['twitter'=>$author->twitter];
		$authorRefactored->name = ['profile'=>'@'.$author->username,'firstname'=> $author->firstname, 'lastname'=>$author->lastname, 'fullname'=> $author->fullname];
		
		$study->author = $authorRefactored;
		$study->categories = $studyModel->categories;
		$study->exists = $studyModel->exists;
		$study->history = ['created'=>$studyModel->created_at,'published' => $studyModel->published,'modified'=> $studyModel->updated_at, "version"=> $studyModel->lastModified];
		$study->mainImage = $studyModel->defaultImage;
		$study->routes = ['default_url'=>$studyModel->defaultUrl, 'sharing_url'=>$studyModel->sharingUrl]; //default url + current url + sharing url
		$study->section = $studyModel->namespace;
		$study->tags = $studyModel->present()->tagsAsString;
		$study->type = $studyModel->type;
		
		$study->updated_at = $studyModel->updated_at;
		$study->created_at = $studyModel->updated_at;
		
		$study->url = $studyModel->url();
		
		
		return $study;
		
	}
	
	private function mapMissing($object){
	
		$page = new \stdClass();
		
		$page->title = $object->title;
		$page->description = 'Bible exchange is your place for growing your Bibl knowledge';
	
		$authorRefactored = new \stdClass();
		$authorRefactored->contact = ['twitter'=>'@bible_exchange'];
		$authorRefactored->name = ['firstname'=> 'Bible', 'lastname'=>'exchange', 'fullname'=> 'Bible exchange'];
		$page->author = $authorRefactored;
		
		$page->categories = 'christianity, bible, religion';
		$page->exists = false;
		$page->history = ['created'=>\Carbon::createFromDate(2015,2,1),'published' => \Carbon::now()->toRfc2822String(),'modified'=> \Carbon::now()->toRfc2822String(), "version"=> \Carbon::now()->toRfc2822String()];
		$page->mainImage = Image::defaultImage();
		$page->routes = ['default_url'=>url('/'), 'sharing_url'=>url('/')]; //default url + current url + sharing url
		$page->section = '/';
		$page->tags = 'christian, bible, study, religion, God';
		$page->type = 'Index';
		
		$page->updated_at = '';
		$page->created_at = '';
		
		$page->url = url('/study');
		
		return $page;
	
	}
	
	private function mapRecording($recordingModel){

		$index = false;
		
		if( $recordingModel->exists === FALSE){
			$count_of_recordings = $recordingModel->count();
			$recordingModel = $recordingModel->first();
			$index = true;
		}

		$page = new \stdClass();
		$page->title = $recordingModel->present()->title;
		$page->description = $recordingModel->description;
		
		$authorRefactored = new \stdClass();
		$authorRefactored->contact = ['twitter'=>'@bible_exchange'];
		$authorRefactored->name = ['profile'=>'@'.$recordingModel->primaryPerson()->username,'firstname'=> $recordingModel->primaryPerson()->firstname, 'lastname'=>$recordingModel->primaryPerson()->lastname, 'fullname'=> $recordingModel->primaryPerson()->fullname];
		$page->author = $authorRefactored;
		
		$page->categories = $recordingModel->categories;
		$page->exists = $recordingModel->exists;
		$page->history = ['created'=>$recordingModel->created_at,'published' => $recordingModel->published,'modified'=> $recordingModel->updated_at, "version"=> $recordingModel->lastModified];
		$page->mainImage = Image::find(1);
		$page->routes = ['default_url'=>$recordingModel->url(), 'sharing_url'=>$recordingModel->url()];//default url + current url + sharing url
		$page->section = 'Recordings';
		$page->tags = $recordingModel->tagsString;
		$page->type = $recordingModel->genre;
		
		$page->updated_at = $recordingModel->updated_at;
		$page->created_at = $recordingModel->dated;
		
		$page->url = $recordingModel->url();		
		
		if($index){
			$page->title = number_format($count_of_recordings).' Recordings';
		}

		return $page;
	
	}
	
	private function mapCourse($courseModel){
	
		$index = false;
	
		if( $courseModel->exists === FALSE){
			$index = true;
		}
	
		$page = new \stdClass();
		
		$authorRefactored = new \stdClass();
		
		if($index){
			
			$count_of_courses = $courseModel->public()->count();
			$courseModel = $courseModel->first();
			
			$page->mainImage = Image::defaultImage();
			$page->title = 'Courses (' . number_format($count_of_courses).')';
			$authorRefactored->name = ['profile'=> null,'firstname'=> null, 'lastname'=> null, 'fullname'=> null];
		}else {
			$page->mainImage = $courseModel->defaultImage;
			$page->title = $courseModel->present()->title;
			$authorRefactored->name = ['profile'=>'@'.$courseModel->owner->username,'firstname'=> $courseModel->owner->firstname, 'lastname'=>$courseModel->owner->lastname, 'fullname'=> $courseModel->owner->fullname];
		}
		
		$authorRefactored->contact = ['twitter'=>'@bible_exchange'];
		
		$page->description = $courseModel->description;
	
		$page->author = $authorRefactored;
	
		$page->categories = $courseModel->categories;
		$page->exists = $courseModel->exists;
		$page->history = ['created'=>$courseModel->created_at,'published' => $courseModel->published,'modified'=> $courseModel->updated_at, "version"=> $courseModel->lastModified];
	
		$page->routes = ['default_url'=>$courseModel->url(), 'sharing_url'=>$courseModel->url()];//default url + current url + sharing url
		$page->section = 'Recordings';
		$page->tags = $courseModel->tagsString;
		$page->type = $courseModel->genre;
	
		$page->updated_at = $courseModel->updated_at;
		$page->created_at = $courseModel->dated;
	
		$page->url = $courseModel->url();

		return $page;
	
	}
}
