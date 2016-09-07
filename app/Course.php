<?php namespace BibleExperience;

use Illuminate\Support\Facades\URL;
use BibleExperience\Core\PresentableTrait;
use BibleExperience\Core\ShortableTrait;
use BibleExperience\Presenters\Contracts\PresentableInterface;
use Str, Cache;

class Course extends \Eloquent implements PresentableInterface {

	protected $table = 'courses';
	protected $appends = array('defaultImage','student','stepsCount','identifier');
	protected $hidden = array('chapters','defaultImage');
	public $fillable = array('bible_verse_id','title','description','user_id','year','public','created_at','updated_at');
	protected $presenter = 'BibleExperience\Presenters\Course';
	
	use PresentableTrait, ShortableTrait;
	
	public static function make( $shortname,$slug, $description,$title)
	{
		$course = new static(compact('shortname', 'slug','description','title'));
	
		return $course;
	}
	
	public function steps()
	{
		return $this->hasMany('BibleExperience\Step');
	}
	
	public function verse()
    {
    	return $this->belongsTo('BibleExperience\BibleVerse','bible_verse_id');
    }
	
	public function getDates()
	{
		//returns this column as Carbon instance!
		return ['created_at','updated_at'];
	}
	
	public function courseInfoByTitle($title)
	{	
		return DB::table('notebooks')->where('title','=',$title)->first();	
	}

	public function notes()
	{
		return $this->belongsToMany('\BibleExperience\Note')->withPivot('orderBy')->orderBy('orderBy','ASC');
	}
	
	public function shareUrl()
	{
		return Url::to($this->uuid);
	}
	
    public function image()
    {
    	return $this->belongsTo('BibleExperience\Image','image_id');
    }
    
    public function getDefaultImageAttribute()
    {
    
    	if($this->image === null)
    	{
    		return Image::defaultImage();
    	}
    
    	return $this->image;
    }
    
    public function owner()
    {
    	return $this->belongsTo('BibleExperience\User','user_id');
    }

 public function getStudentAttribute()
    {
		return \Auth::user();
    }

 public function getStepsCountAttribute()
    {
		return $this->steps->count();
    }
  public function getIdentifierAttribute()
    {
		return $this->id;
    }
}
