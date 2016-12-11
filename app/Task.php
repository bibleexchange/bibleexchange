<?php namespace BibleExperience;

class Task extends \Eloquent {
	
	protected $fillable = array('title','instructions','study_id','task_type_id','points','orderBy');
	
	public $timestamps = true;	
	
	public function taskType(){
		return $this->belongsTo('BibleExperience\TaskType');
	}
	
	public function studies(){
		return $this->belongsToMany('BibleExperience\Study','study_task','task_id','study_id');
	}
	
	public function properties()
	{
		return $this->hasMany('BibleExperience\TaskProperty','task_id');
	}
	
	public function questions()
	{
		return $this->hasMany('BibleExperience\Question','task_id');
	}
	
	public function buildEditor(){

		switch($this->task_type_id){
			
			case 1://Read
				return new \BibleExperience\Tasks\Read($this);
				break;
			
			case 2://Listen
				return new \BibleExperience\Tasks\Listen($this);
				break;
			
			case 3://Watch
				return new \BibleExperience\Tasks\Watch($this);
				break;
						
			case 4://Write
				return new \BibleExperience\Tasks\Write($this);
				break;
			
			case 5://Review
				return new \BibleExperience\Tasks\Review($this);
				break;
			
			case 6://Test
				return new \BibleExperience\Tasks\Test($this);
				break;
			
			case 7://Apply
				return new \BibleExperience\Tasks\Apply($this);
				break;
			
			case 8://Memorize
				return new \BibleExperience\Tasks\Memorize($this);
				break;
			
			default:
				return App::abort();
		}
		
	}

	
}