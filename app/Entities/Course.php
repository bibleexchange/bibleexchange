<?php namespace BibleExchange\Entities;

use Illuminate\Support\Facades\URL;
use BibleExchange\Core\PresentableTrait;
use BibleExchange\Core\ShortableTrait;
use BibleExchange\Presenters\Contracts\PresentableInterface;
use Str, Cache;

class Course extends \Eloquent implements PresentableInterface {

	protected $table = 'courses';
	protected $appends = array('chapters','defaultImage','mainVerse');
	protected $hidden = array('chapters','defaultImage');
	public $fillable = array('title','description','user_id','year','public','created_at','updated_at');
	protected $presenter = 'BibleExchange\Presenters\Course';
	
	use PresentableTrait, ShortableTrait;
	
	public static function make( $shortname,$slug, $description,$title)
	{
		$course = new static(compact('shortname', 'slug','description','title'));
	
		return $course;
	}
	
	//returns this column as Carbon instances!
	public function getDates()
	{
		return ['created_at','updated_at'];
	}
	
	public function profileUrl($username)
	{
		return Url::to('/@'.$username.'/courses/'.$this->slug);
	}

	public function courseInfoByTitle($title)
	{	
		return DB::table('courses')->where('title','=',$title)->first();	
	}

 public function sections()
    {
        return $this->hasMany('BibleExchange\Entities\Section', 'course_id')->orderBy('orderBy','ASC');
    }
    
	public function url()
	{
		return Url::to('/course/'.$this->id.'-'.Str::slug($this->title));
	}
	
	public function rssUrl()
	{
		return Url::to('/course/'.$this->id.'-'.Str::slug($this->title). '/rss');
	}
	
	public function shareUrl()
	{
		return Url::to($this->uuid);
	}
	
	public function editUrl()
	{
		return Url::to('/user/course-maker/'.$this->id);
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
    
	public function collections()
	  {
		return $this->belongsToMany('Collection');
	  }
	  
	 public static function posts()
	  {
		return $this->belongsToMany('Post')->withPivot('post_id', 'course_id');
	  }
	
	/*
	**CUSTOM ATTRIBUTES 
	*/
	
	public function getChaptersAttribute()
    {
        $chapters = $this->chapters()->getQuery()->orderBy('sections.orderBy', 'asc')->orderBy('chapters.orderBy', 'asc')->get();
        return $chapters;
    }
	
    public function getMainVerseAttribute()
    {
    	return null;
    }
    
    public function owner()
    {
    	return $this->belongsTo('BibleExchange\Entities\User');
    }
    
    public function editors()
    {
    	return $this->belongsToMany('BibleExchange\Entities\User', 'course_user', 'course_id', 'user_id');
    }	
	
	public function isPublic(){

		if($this->public == 1 | $this->public == '1'){
			return true;
		}

		return false;
	}
	
	public function scopePublic($query){
			return $query->where('public', 1);
		
	}

	public function studies($publicOnly = true)
	{
		
		$fileName = $this->id.'_studies_public-'.$publicOnly;
		
		if ( ! Cache::has($fileName)) {			
			
			$collection = $this->getStudies($publicOnly, $fileName);
								
		} else {
			$collection = Cache::get($fileName);
		}
		
		$collection = $this->getStudies($publicOnly);
		
		return $collection;
		
	}
	
	public function getStudies($publicOnly = true, $fileName = 'empty')
	{
		
		$studies = [];
		
		if($this->sections != null)
		{
			foreach ($this->sections AS $section){
					
				if($publicOnly){
				
					foreach($section->studies()->public()->get() AS $s){
						$studies[$s->id] = $s;
					}	
				
				} else {
					
					foreach($section->studies AS $s){
						$studies[$s->id] = $s;
					}
					
				}
				
				
			}
		}
		
		$collection =  new \Illuminate\Support\Collection( $studies );
		
		Cache::remember($fileName, 60, function() use ($collection) {
			return $collection;
		});
		
		return $collection;
		
	}

	public function publish()
	{
		if($this->public === 1){
			$this->public = 0;
		}else {
			$this->public = 1;
		}
	
		return $this;
	
	}
	
	public function hint()
	{
		return ' "'. $this->title . "' ";
	}
	
}