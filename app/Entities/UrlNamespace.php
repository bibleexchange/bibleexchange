<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class UrlNamespace extends Model {
	
	protected $table = 'namespaces';
	
	protected $fillable = ['name','role_id'];
	
	protected $appends = ['url'];
	
	public function getUrlAttribute(){
		return url('/');
	}

}
