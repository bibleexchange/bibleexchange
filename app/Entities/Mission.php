<?php namespace BibleExchange\Entities;

class Mission extends Eloquent {

	protected $fillable = array('author', 'title', 'description','body','status','mission');
	
	public static $rules = array(
    'author'=>'required|min:2',
    'mission'=>'required|min:2',
    'title'=>'required',
    'description'=>'',
    'body'=>'required'
    );
	

}