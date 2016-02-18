<?php namespace BibleExchange\Entities;
 
class Question extends \Eloquent {
	
	protected $table = 'questions';
	
	protected $fillable = ['task_id','question','answer','readable_answer','options','weight','question_type_id'];
	
	public function answers()
    {
        return $this->hasMany('BibleExchange\Entities\Answer');
    }
	
    public function answered($user_id)
    {
    	return $this->answers()->user($user_id)->latest()->first();
    }
   
	public function study()
	{
	    return $this->belongsTo('BibleExchange\Entities\Study', 'study_id');
	}	
	
	public function type()
	{
		return $this->belongsTo('BibleExchange\Entities\QuestionType', 'question_type_id');
	}
	
	
}