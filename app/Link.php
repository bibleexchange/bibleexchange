<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Link extends Model {

	protected $fillable = ['url'];
		
	protected $table = 'links';
	
	protected $appends = [];
	
	protected $presenter = 'BibleExperience\Presenters\RecordingPresenter';
	
	protected $dates = ['dated','created_at','updated_at'];
}
