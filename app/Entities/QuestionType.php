<?php namespace BibleExchange\Entities;
 
class QuestionType extends \Eloquent {
	
	protected $table = 'question_types';
	
	protected $fillable = ['name','code','instructions','create_instructions'];
	
	public $timestamps = false;
	
}