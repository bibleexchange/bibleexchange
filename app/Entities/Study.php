<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use BibleExchange\Core\AmenableTrait;
use BibleExchange\Core\PresentableTrait;
use BibleExchange\Core\CommentableTrait;
use BibleExchange\Entities\Uuid;

use Markdown, Str, Carbon, Htmldom;

class Study extends Model {
	
	use AmenableTrait, PresentableTrait, CommentableTrait;
	
	protected $presenter = 'BibleExchange\Presenters\StudyPresenter';
	
	protected $fillable = ['uuid','main_verse','namespace_id','title','description','user_id','restrictions','counter','is_redirect','is_published','is_public','random','published_html','latest_text_id','length','content_model','lang','updated_at','created_at'];
	
	protected $appends = array('defaultImage','lastChangeWasMade','outline','courses');
	
	public function getDates()
	{
		return ['created_at','updated_at','lastChangeWasAt','published_at'];
	}
	
	/* Relationships  */
	
	
	public function tasks()
	{
		return $this->hasMany('BibleExchange\Entities\Task');
	}
	
	public function questions()
	{
		return $this->hasManyThrough('BibleExchange\Entities\Question','BibleExchange\Entities\Task');
	}
	
	public function userAnswers($user)
	{
		$questions = $this->questions()->select('questions.id')->lists('questions.id');

		$answers = $user->answers()->whereIn('question_id', $questions)->get();
		
		return $answers;
	}
	
	public function testProgress($user)
	{
		$possible_points = array_sum($this->questions()->lists('weight'));
		$awarded_points = array_sum($this->userAnswers($user)->lists('points'));
	
		$percentage = $awarded_points/$possible_points;
		
		return round($percentage * 100, 0);
	}
	
	public function tasksProperties()
	{
		return $this->morphMany('BibleExchange\Entities\TaskProperty','taskable');
	}

	public function text()
	{
		return $this->belongsTo('BibleExchange\Entities\Text','latest_text_id')->first();
	}
	
	public function group()
	{
		return $this->belongsTo('BibleExchange\Entities\UrlNamespace','namespace_id');
	}
	
	public function sections()
	{
		return $this->belongsToMany('\BibleExchange\Entities\Section')->orderBy('orderBy','ASC')->orderBy('created_at','ASC');
	}
	
	public function getCoursesAttribute()
	{
		$courses = [];
		
		foreach ($this->sections()->get() AS $section){
			
			$courses[] = $section->course;
			
		}
		
		return $courses;
	}
	
	public static function scopeSearch($query,$search)
	{
		return $query->where('title','LIKE','%'.$search.'%')
		->orWhere('description','LIKE','%'.$search.'%')
		->orderBy('title', 'DESC');
	}
	
	public static function scopeSearchPublicTitle($query,$search)
	{
		return $query->where('is_public','1')
		->where('title','LIKE','%'.$search.'%')
		->orderBy('title', 'DESC');
	}
	
	public static function scopeSearchTitle($query,$search)
	{
		return $query->where('title','LIKE','%'.$search.'%')
		->orderBy('title', 'DESC');
	}
	
	public static function scopeSearchUserTitle($query,$search, $user)
	{
		return $query->where('title','LIKE','%'.$search.'%')
		->where('user_id', $user->id)
		->orderBy('title', 'DESC');
	}
	
	public static function scopeSearchUserDescription($query,$search, $user)
	{
		return $query->where('description','LIKE','%'.$search.'%')
		->where('user_id', $user->id)
		->orderBy('title', 'DESC');
	}
	
	public static function scopeSearchPublicDescription($query,$search)
	{
		return $query->where('is_public','1')
		->where('description','LIKE','%'.$search.'%')
		->orderBy('title', 'DESC');
	}
	
	public static function searchForSimilar( $string, $public = true){
		
		$ignore = ['a','able','about','above','across','after','again','against','ain\'t','all','almost','also','am','among','an','and','any','are','aren\'t','as','at','be','because','been','before','being','below','between','both','but','by','can','can\'t','cannot','could','could\'ve','couldn\'t','dear','did','didn\'t','do','does','doesn\'t','doing','don\'t','down','during','each','either','else','ever','every','few','for','from','further','get','got','had','hadn\'t','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','he\'s','her','here','here\'s','hers','herself','him','himself','his','how','how\'d','how\'ll','how\'s','however','i','i\'d','i\'ll','i\'m','i\'ve','if','in','into','is','isn\'t','it','it\'s','its','itself','just','least','let','let\'s','like','likely','may','me','might','might\'ve','mightn\'t','more','most','must','must\'ve','mustn\'t','my','myself','neither','no','nor','not','of','off','often','on','once','only','or','other','ought','our','ours','ourselves','out','over','own','rather','said','same','say','says','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','should\'ve','shouldn\'t','since','so','some','such','than','that','that\'ll','that\'s','the','their','theirs','them','themselves','then','there','there\'s','these','they','they\'d','they\'ll','they\'re','they\'ve','this','those','through','tis','to','too','twas','under','until','up','us','very','wants','was','wasn\'t','we','we\'d','we\'ll','we\'re','we\'ve','were','weren\'t','what','what\'d','what\'s','when','when\'d','when\'ll','when\'s','where','where\'d','where\'ll','where\'s','which','while','who','who\'d','who\'ll','who\'s','whom','why','why\'d','why\'ll','why\'s','will','with','won\'t','would','would\'ve','wouldn\'t','yet','you','you\'d','you\'ll','you\'re','you\'ve','your','yours','yourself','yourselves'];
		
		$similarStudies = [];
		
		$searchWords[] = explode("/",$string);
		
			foreach(array_flatten($searchWords) AS $a){
				
					$words[] = explode('-',$a);
			}
		
		$words = array_diff(array_flatten($words), $ignore);
		
		if($public){
		
			foreach( $words As $word )
			{
				$results1[] = Study::searchPublicTitle($word)->lists('id');
					
				$results2[] = Study::searchPublicDescription($word)->lists('id');
			}
		
		}else {
			
			foreach( $words As $word )
			{
				$results1[] = Study::searchUserTitle($word, \Auth::user())->lists('id');
				$results2[] = Study::searchUserDescription($word, \Auth::user())->lists('id');
			}
			
		}
		
		$similarStudiesIds = array_merge(array_flatten($results1),array_flatten($results2));
		
		$ranks = array_count_values($similarStudiesIds);
		
		foreach($ranks AS $key => $value){
		
			$similarStudies[] = Study::find($key);
				
		}

		return $similarStudies;
		
	}
	
	public function delete()
	{
		// Delete the comments
		$this->comments()->delete();
	
		// Delete the lesson post
		return parent::delete();
	}
	
	public function mainVerse()
	{
		return $this->belongsTo('BibleExchange\Entities\BibleVerse','main_verse');
	}
	
	public function profileUrl($username)
	{
		if($this->course == null){
			return Url::to('/@'.$username.'/lessons/'.$this->slug);
		}
		return Url::to('/@'.$username.'/courses/'.$this->course->slug.'/'.$this->slug);
	}
	
	public function url()
	{
		return url('/study/'.$this->id.'-'. Str::slug($this->title));
	}
	
	public function editUrl()
	{
		return url('/user/study-maker/'.$this->id.'/edit');
	}
	
	public function previewUrl()
	{
		return url('/user/study-maker/'.$this->id.'/preview');
	}
	
	public function urlCourse()
	{
		return '/'.$this->course->slug.'/'.$this->slug;
	}
	
	public static function allPublished(){
	
		return self::where('published_html','!=',null);
	}
	
	public static function allNotPublished(){
	
		return self::where('published_html','=',null);
	}
	
	/*
	
	Media Management
	
	*/
	
	public function recordings()
	{
		return $this->belongsToMany('\BibleExchange\Entities\Recording','recording_study','study_id','recording_id');
	}
	
	public function audios()
	{
		return new \BibleExchange\Entities\Recording;
	}
	
	public function videos()
	{
		return new \BibleExchange\Entities\Recording;
	}
	
	public function creator(){
		return $this->belongsTo('\BibleExchange\Entities\User','user_id');
	}
	
	public function isCreator($user){

		if($this->creator->id === $user->id){
			return true;
		}
		
		return false;
	}
	
	public function isPublic(){

		if($this->is_public == 1 | $this->is_public == '1'){
			return true;
		}

		return false;
	}
	
	public function isPublished(){

		if($this->is_published == 1 | $this->is_published == '1'){
			return true;
		}
		
		return false;
	}
	
	public function editors()
	{
		return \BibleExchange\Entities\Revision::editorsFromArray($this->revisions()->get());
	}
	
	public function tags()
	{
		return $this->belongsToMany('\BibleExchange\Entities\Tag');
	}
	
	public function image()
	{
		return $this->belongsTo('BibleExchange\Entities\Image','image_id');
	}
	
	public function getDefaultImageAttribute()
	{

		if($this->image === null)
		{
			return Image::defaultImage();
		}

		return $this->image;		
	}
	
	public function revisions()
	{
		return \BibleExchange\Entities\Revision::where('study_id',$this->id);
	}
	
	public function revision()
	{
		return \BibleExchange\Entities\Revision::where('text_id', $this->latest_text_id)->where('study_id',$this->id)->first();
	}
	
	public function getLastChangeWasMadeAttribute(){
		
		if($this->revision() !== null){
			
			return $this->revision()->touched_at;
		} else {
		
			return Carbon::createFromDate(1900-01-01);
		
		}
	}
	
	public function scopePublic($query)
	{
		return $query->where('is_public', '!=',0);
	}
	
	public function scopeApproved($query)
	{
		return $query->where('approved', '!=', 0);
	}
	
	public function scopePublished($query)
	{
		return $query->where('is_published', '!=', 0);
	}
	
	public function getNextLessonAttribute()
	{
	
		$lessons = $this->course->lessons->lists('id');
	
		$current = arrayearch($this->id,$lessons);
	
		if (!isset($lessons[$current+1])){
			return null;
		}
	
		$nextIndex = $lessons[$current+1];
	
		return Lesson::find($nextIndex);
	
	}
	
	public static function make($description,$latest_text_id, $namespace_id, $title, $is_published, $user_id)
	{
		
		$uuid = Uuid::uuid4()->getHex();
		
		$study = new static(compact('description','uuid','latest_text_id','namespace_id','title','is_published','user_id'));
	
		return $study;
	}
	
	public function publish()
	{
		if($this->text() !== null){
			$text = $this->text()->text;
		}else{
			$text = '';
		}
		
		$orig_html = nl2br(Markdown::convertToHtml($text));
		
		$dom_html = new \Htmldom($orig_html);
		$counter = 1;
		
		foreach($dom_html->find('h2') as $element) 
		{
			$search = '<h2>'.$element->innertext.'</h2>';
			$replace = '<h2 id="h2-'.$counter.'">'.$element->innertext.'</h2>';
			
			$orig_html = str_replace($search, $replace, $orig_html);
			
			$counter++;
		}

		$this->published_html = $orig_html;
		$this->published_at = Carbon::now();
		$this->is_published = 1;
		
		return $this;
	}
	
	public function makePublicOrPrivate()
	{
		if($this->isPublic()){
			$number  = 0;
		}else{
			$number  = 1;
		}
		
		$this->is_public = $number;
		
		return $this;
		
	}
	
	public function getNextStudy()
	{
	
		$lessons = $this->course->lessons->lists('id');
	
		$current = array_search($this->id,$lessons);
	
		if (!isset($lessons[$current+1])){
			return null;
		}
	
		$nextIndex = $lessons[$current+1];
	
		return Lesson::find($nextIndex);
	
	}
	
	public function getOutlineAttribute()
	{
		$html = new \Htmldom($this->published_html);
		$string = '<ol>';
		$counter = 1;
		
		foreach($html->find('h2') as $element) 
		{
			   $string .= '<li><a href="#h2-'.$counter.'">' . $element->innertext . '</a></li>';
			   $counter++;
		}
		
		$string .= '</ol>';
		
		return $string;
		
	}
}
