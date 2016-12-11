<?php namespace BibleExperience;

class Site extends BaseModel {

  protected $hidden = ['created_at','updated_at'];
  protected $fillable = ['name', 'description', 'email', 'lang', 'create_lrs', 'registration', 'restrict', 'domain', 'super'];
  	protected $appends = array('who_creates_lrs');
  
  public static function createLrsForDB(array $options){
	  return json_encode($options);
  }
  
  	public function getWhoCreatesLrsAttribute()
    {
        return json_decode($this->create_lrs);
    }
	
}
