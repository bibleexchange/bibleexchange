<?php namespace BibleExperience;

use Auth;
use BibleExperience\Core\UUIDTrait;

class BibleBook extends \Eloquent {
	use UUIDTrait;
	protected $table = 'biblebooks';

	public $fillable = array('title','slug','t','g','library_id');
	protected $appends = array('chapterCount','uuid', 'lessonsCount');
	public $timestamps = false;
	
	public static function scopeSearch($query,$search)
	{
		return $query
			->where('n','LIKE','%'.$search.'%')
			->orWhere('slug','LIKE','%'.$search.'%')
			->orWhere('t','LIKE','%'.$search.'%');
	}
	
	public function url()
	{
	    return '/kjv/' . $this->slug;
	}
	
	 public function findByName($name){			
		$name = strtolower(substr($name,0,5));
		if($name !== ''){
			return $this->where('slug','LIKE',"%".preg_replace('/\s+/', '', $name)."%")->first();
		}else{
			return null;
		}
	 }

 public function chapters()
    {
        return $this->hasMany('\BibleExperience\BibleChapter');
    }

 public function lessons()
    {
        return $this->hasMany('\BibleExperience\BibleChapter');
    }
	
	
	public function chaptersByOrderBy($chapter)
    {
        return $this->hasMany('\BibleExperience\BibleChapter')->where('order_by','=',$chapter)->first();
    }
	
	public function verses()
    {
        return $this->hasMany('\BibleExperience\BibleVerse', 'b');
    }
	
    public function isOT(){
    	return $this->where('t','OT');
    }
    
    public function isNT(){
    	return $this->where('t','NT');
    }    
    
    public static function testaments(){
		
    	$books = new \BibleExperience\BibleBook;
    	
    	$books->both = $books->lists('n');
    	
    	$books->ot = array_where($books->both, function($key, $value)
						{
						   if ($key <= 38){ return $value;}
						});

    	$books->nt = array_where($books->both, function($key, $value)
						{
						   if ($key >= 39){ return $value;}
						});
    	
    	return $books;
    }
	
	public function getChapterCountAttribute(){
    	return $this->chapters()->count();
    }

 public function getLessonsCountAttribute()
    {
	if($this->lessons === null){
	  return 0;
	}else{
	  return $this->lessons->count();
	}
    }

  public function getUUIDAttribute()
    {
		return base64_encode("BibleExperience\BibleBook_".$this->id);
    }
	
}
