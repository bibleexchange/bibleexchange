<?php namespace BibleExchange\Entities;
 
class Answer extends \Eloquent {
	
	protected $fillable = ['answer','question_id','points','message','attempts','user_id','created_at','updated_at'];
	
	public function question()
	{
	    return $this->belongsTo('BibleExchange\Entities\Question', 'question_id');
	}
	
	public static function scopeUser($query,$user_id)
	{
		return $query->where('user_id','=',$user_id);
	}
	
	public function latest(){
		return $this->orderBy('updated_at','DESC');
	}
	
	public function gradeIt(){
		
		switch($this->question->type->code){
			case 'multiple-choice':
				$this->gradeExactSolution();
				break;
				
			case 'true-false':
				$this->gradeExactSolution();
				break;
				
			case 'short-answer':
				$this->gradeContainsSolution();
				break;
				
			case 'essay':
				$this->gradeEssay();
				break;
				
			default:
				$this->message = 'Your answer is pending review.';
				$this->points = 0;
		}
		
		return $this;
		
	}
	
	public function gradeExactSolution(){
		
		if($this->question->answer === $this->answer){
			$this->points = $this->question->weight;
			$this->message = 'Accepted.';
		}else {
			$this->points = 0;
			$this->message = 'Try again.';
		}
		
		return $this;
	}
	
	public function gradeContainsSolution(){
		
		$solution = preg_replace("/\p{P}/", "", strtolower($this->question->answer));
		$response = preg_replace("/\p{P}/", "", strtolower($this->answer));
		
		$solution = str_replace('  ', ' ',$solution);
		$response = str_replace('  ', ' ',$response);
		
		$solutionArray = explode(' ',  $solution);
		$userAnswerArray = explode(' ', $response);
		
		$intersect = array_intersect($solutionArray, $userAnswerArray);
		
		if (count($intersect) === count($solutionArray )){
			$this->message = 'Your answer was accepted.';
			$this->points = $this->question->weight;
		}else{
			$this->message = 'Not a close enough match. Try again.';
			$this->points = 0;
		}

		return $this;
	
	}
	
	public function gradeEssay(){
	
		$this->message = 'Your essay will be reviewed by an instuctor.';
		$this->points = 0;
		
		return $this;
	
	}
}