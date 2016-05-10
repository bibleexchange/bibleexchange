<?php namespace BibleExchange\Entities;

class Task extends \Eloquent {
	
	protected $fillable = array('title','instructions','study_id','task_type_id','points','orderBy');
	
	public $timestamps = true;	
	
	public function taskType(){
		return $this->belongsTo('BibleExchange\Entities\TaskType');
	}
	
	public function studies(){
		return $this->belongsToMany('BibleExchange\Entities\Study','study_task','task_id','study_id');
	}
	
	public function properties()
	{
		return $this->hasMany('BibleExchange\Entities\TaskProperty','task_id');
	}
	
	public function questions()
	{
		return $this->hasMany('BibleExchange\Entities\Question','task_id');
	}
	
	public function buildEditor(){

		switch($this->task_type_id){
			
			case 1://Read
				return new \BibleExchange\Entities\Tasks\Read($this);
				break;
			
			case 2://Listen
				return new \BibleExchange\Entities\Tasks\Listen($this);
				break;
			
			case 3://Watch
				return new \BibleExchange\Entities\Tasks\Watch($this);
				break;
						
			case 4://Write
				return new \BibleExchange\Entities\Tasks\Write($this);
				break;
			
			case 5://Review
				return new \BibleExchange\Entities\Tasks\Review($this);
				break;
			
			case 6://Test
				return new \BibleExchange\Entities\Tasks\Test($this);
				break;
			
			case 7://Apply
				return new \BibleExchange\Entities\Tasks\Apply($this);
				break;
			
			case 8://Memorize
				return new \BibleExchange\Entities\Tasks\Memorize($this);
				break;
			
			default:
				return App::abort();
		}
		
	}

	
}