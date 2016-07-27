<?php namespace BibleExperience;

class UrlNamespace extends BaseModel {
	
	protected $table = 'namespaces';
	
	protected $fillable = ['name','role_id'];
	
	protected $appends = ['url'];
	
	public function getUrlAttribute(){
		return url('/');
	}

}
