<?php namespace BibleExchange\Entities;
 
class ChapterTrans extends Eloquent {
	
	protected $fillable = array('language','chapters_id','title');
	
	 protected $table = 'chapter_trans';
	
	public static $rules = array(
    'language'=>'required',
    'cdl_id'=>'required',
	'title'=>''
    );
	
	
}