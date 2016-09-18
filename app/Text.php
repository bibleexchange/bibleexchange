<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class Text extends Model {

	protected $fillable = ['revision_id','cached'];
	    
	protected $appends = ['rawContent','htmlContent'];
	
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

	public function getRawContentAttribute()
	{
		$x = explode("_",$this->revision->content_format);

		switch($x[0]){
		  
		  case 'link':		
			return file_get_contents($this->revision->body);
		  break;
		  default:
			return $this->revision->body;
		  break;
		}

	}

	public function getHtmlContentAttribute()
	{
		if(strpos($this->revision->content_format,'md')){
		  return \Markdown::convertToHtml($this->rawContent);
		}else{
		  return $this->rawContent;
		}

	}


	
}
