<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Revision extends BaseModel {

	protected $fillable = ['body','content_format','editor_id'];
	
	protected $appends = [];
	
	public function getDates()
	{
		return ['created_at','updated_at'];
	}
	
	public static function make($body, $content_format, $editor_id)
	{
		$updated_at = \Carbon::now()->toDateTimeString();
		$created_at = \Carbon::now()->toDateTimeString();

		$revision = new static(compact('body', 'content_format','editor_id','created_at','updated_at'));
	
		return $revision;
	}
	
	public function editor(){
		return BelongsTo('\BibleExperience\User','editor_id');
	}
	
	public static function editorsFromArray($array_of_revisions){
		
		$array = [];
		$ids = [];
		foreach($array_of_revisions AS $revision){
			
			if( ! in_array($revision->user_id, $ids)){
				$ids[] = $revision->user_id; 
				$array[] = \BibleExperience\User::find($revision->user_id);
			}
		}
		
		return $array;
		
	}
}
