<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Text extends Model {

	protected $fillable = ['revision_id','cached'];
	    
	protected $appends = [];
	
	public $timestamps = false;
	
	public static function make($revision_id, $cached)
	{

		$text = new static(compact('revision_id', 'cached'));
	
		return $text;
	}

	public function edit($body, $content_format, $editor_id){

	  $revision = \BibleExperience\Revision::make(compact('body', 'content_format', 'editor_id'));
	  $revision->save();
	  
	  $this->revision_id = $revision->id;
	  $this->save();

	  return $this->revision;
		
	}
	
	public function revision()
	{
		return $this->belongsTo('\BibleExperience\Revision');
	}
	
}
