<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Revision extends Model {

	protected $fillable = ['study_id','text_id','comment','user_id','user_text','touched_at','minor_edit','deleted','len','parent_id','sha1','content_model','content_format'];
	
	protected $appends = [];
	
	public $timestamps = false;
	
	public function getDates()
	{
		return ['created_at','touched_at'];
	}
	
	public static function make($study_id, $text_id, $comment, $user_id, $minor_edit, $len)
	{
		$touched_at = \Carbon::now()->toDateTimeString();
		
		$revision = new static(compact('study_id', 'text_id', 'comment', 'user_id','minor_edit', 'len','touched_at'));
	
		return $revision;
	}
	
	public function editor(){
		return BelongsTo('\BibleExchange\Entities\User');
	}
	
	public static function editorsFromArray($array_of_revisions){
		
		$array = [];
		$ids = [];
		foreach($array_of_revisions AS $revision){
			
			if( ! in_array($revision->user_id, $ids)){
				$ids[] = $revision->user_id; 
				$array[] = \BibleExchange\Entities\User::find($revision->user_id);
			}
		}
		
		return $array;
		
	}
}
