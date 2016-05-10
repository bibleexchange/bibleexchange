<?php namespace BibleExchange\Entities;
use LaravelBook\Ardent\Ardent;

class Video extends Ardent {
	
	protected $table = 'videos';
	
	protected $appends = ['rows','names','locations','columns'];
	
	protected $fillable = ['fileName','located'];
	
	public static $rules = array(
	'fileName'=> 'required',
	'located'=> 'required'
    );	
	
	public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
	public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called
	public $autoPurgeRedundantAttributes = true;
	
	public function chapters()
    {
         return $this->belongsToMany('Chapter', 'chapter_video', 'video_id', 'chapter_id');
    }
	
    public function getRowsAttribute()
    {
        return $this->orderBy('id','DESC')->paginate(15);  
    }	

    public function getNamesAttribute()
    {
        return ['one'=>'Video','many'=>'Videos','url'=>'videos'];  
    }	
   
   		public function getLocationsAttribute(){

		return ['0' => 'http://www.deliverance.me/assets/', '1' => '//www.youtube.com/embed/'];

	}
   
   public function getColumnsAttribute()
    {
        return Schema::getColumnListing($this->table);  
    }
	
	public function search($search_field = NULL, $search_string = NULL)
    {
        if ($search_string == NULL || $search_field == NULL){
		return $this->orderBy('id','DESC')->paginate(15);  
		}else{
		return $this->where($search_field,'LIKE', '%'.$search_string.'%')->orderBy('id','DESC')->paginate(15);
		}
    }	
	
}