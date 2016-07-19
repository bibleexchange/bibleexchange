<?php namespace BibleExperience\Entities;

use Auth;

class BibleBook extends \Eloquent {
	
	protected $table = 'key_english';

	public $fillable = array('n','t','g');
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
        return $this->hasMany('\BibleExperience\Entities\BibleChapter', 'key_english_id');
    }
	
	public function chaptersByOrderBy($chapter)
    {
        return $this->hasMany('\BibleExperience\Entities\BibleChapter', 'key_english_id')->where('orderBy','=',$chapter)->first();
    }
	
	public function verses()
    {
        return $this->hasMany('\BibleExperience\Entities\BibleVerse', 'b');
    }
	
    public function isOT(){
    	return $this->where('t','OT');
    }
    
    public function isNT(){
    	return $this->where('t','NT');
    }    
    
    public static function testaments(){
		
    	$books = new \BibleExperience\Entities\BibleBook;
    	
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
}