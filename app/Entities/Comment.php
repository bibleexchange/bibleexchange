<?php namespace BibleExchange\Entities;

class Comment extends \Eloquent {
	
	/**
	 * @var array
	 */
	protected $fillable = ['user_id', 'commentable_id','commentable_type','body'];
	
	
	public function commentable(){
		
		return $this->morphTo();
	}
	
	public static function publish($body, $commentable_id, $commentable_type,$user_id)
	{
		$comment= new static(compact('body','commentable_id','commentable_type','user_id'));
		return $comment;
	}
	
	public function owner()
	{
		return $this->belongsTo('BibleExchange\Entities\User', 'user_id');
	}    
    
}
