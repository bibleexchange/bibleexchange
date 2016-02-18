<?php namespace BibleExchange\Entities;

class Transcript extends \Eloquent {
	protected $fillable = ['user_id','course_id','credits_attempted','percentage'];
	protected $appends = array('gpa','totalgpv');
	
	public function student(){
		return $this->belongsTo('User','user_id');
	}
	
	public function course(){
	
		return $this->belongsTo('Course','course_id');
	
	}
	
	public function getGpaAttribute()
    {		
        $gpv = ($this->percentage / 25);
		
		return number_format(round($gpv,2),2);

    }
	
		public function getTotalgpaAttribute()
    {	
		
		return round($this->gpa * $this->credits_attempted,2);

    }
}