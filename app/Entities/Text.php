<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class Text extends Model {

	protected $fillable = ['text','flags'];
	    
	protected $appends = [];
	
	public $timestamps = false;
	
	public static function make($text){

		$text = new static(compact('text'));
		
		return $text;
		
	}
	
	public function revision()
	{
		return $this->belongsTo('\BibleExchange\Entities\Revision');
	}
	
}
