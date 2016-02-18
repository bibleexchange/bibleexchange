<?php namespace BibleExchange\Entities;

class Spotlight extends \Eloquent {
	protected $fillable = [ 'audios_id' , 'image' , 'active' , 'orderBy'	];

	protected $table = 'spotlights';
			
	public static $rules = array(
	  'audios_id' =>'required',
	  'image' =>'',
	  'active' =>'required|integer',
	  'orderBy' =>'required|integer'
    );
	
	public function audio()
	{
		return $this->belongsTo('Audio', 'audios_id');
	}

}