<?php namespace BibleExperience\Entities;

class Task extends \Eloquent {
	
	protected $fillable = array('title','instructions','study_id','task_type_id','points','orderBy');
	
	public $timestamps = true;	
	
	public function taskType(){
		return $this->belongsTo('BibleExperience\Entities\TaskType');
	}
	
	public function studies(){
		return $this->belongsToMany('BibleExperience\Entities\Study','study_task','task_id','study_id');
	}
	
	public function properties()
	{
		return $this->hasMany('BibleExperience\Entities\TaskProperty','task_id');
	}
	
	public function questions()
	{
		return $this->hasMany('BibleExperience\Entities\Question','task_id');
	}
	
	public function buildEditor(){

		switch($this->task_type_id){
			
			case 1://Read
				return new \BibleExperience\Entities\Tasks\Read($this);
				break;
			
			case 2://Listen
				return new \BibleExperience\Entities\Tasks\Listen($this);
				break;
			
			case 3://Watch
				return new \BibleExperience\Entities\Tasks\Watch($this);
				break;
						
			case 4://Write
				return new \BibleExperience\Entities\Tasks\Write($this);
				break;
			
			case 5://Review
				return new \BibleExperience\Entities\Tasks\Review($this);
				break;
			
			case 6://Test
				return new \BibleExperience\Entities\Tasks\Test($this);
				break;
			
			case 7://Apply
				return new \BibleExperience\Entities\Tasks\Apply($this);
				break;
			
			case 8://Memorize
				return new \BibleExperience\Entities\Tasks\Memorize($this);
				break;
			
			default:
				return App::abort();
		}
		
	}

	
}