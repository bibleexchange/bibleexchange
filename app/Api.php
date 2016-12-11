<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Api extends BaseModel {

	protected $fillable = ['basic_key','basic_secret','client_id'];
	protected $table = "api";
	protected $appends = [];
	
	public function client()
	{
		return $this->belongsTo('BibleExperience\Client');
	}
	
}
