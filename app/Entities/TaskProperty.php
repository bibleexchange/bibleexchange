<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use BibleExchange\Entities\User;

class TaskProperty extends Model {

	protected $fillable = ['task_id','taskable_id','taskable_type','created_at','updated_at'];
	
	private $relatedObject = null;
	
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
 
    public function task()
    {
        return $this->belongsTo('BibleExchange\Entities\Task','task_id');
    }
    
    public function taskable()
    {
    	return $this->morphTo();
    }
    
    public function regarding($object)
    {
    	if(is_object($object))
    	{
    		$this->taskable_id   = $object->id;
    		$this->taskable_type = get_class($object);
    	}
    
    	return $this;
    }
    
    public function hasValidObject()
    {
    	try
    	{
    		$object = call_user_func_array($this->taskable_type . '::findOrFail', [$this->taskable_id]);
    	}
    	catch(\Exception $e)
    	{
    		return false;
    	}
    
    	$this->relatedObject = $object;
    
    	return true;
    }
    
    public function getObject()
    {
    	if(!$this->relatedObject)
    	{
    		$hasObject = $this->hasValidObject();
    
    		if(!$hasObject)
    		{
    			throw new \Exception(sprintf("No valid object (%s with ID %s) associated with this task.", $this->object_type, $this->object_id));
    		}
    	}
    
    	return $this->relatedObject;
    }

    public static function taskThis($task_id, $taskable_type, $taskable_id)
    {
    	$property = self::create([
			'task_id' => $task_id, 
			'taskable_type'=>$taskable_type,
			'taskable_id'=>$taskable_id
			])->save();
  
    	return $property;
    }
   
    public static function untaskThis(Task $task, $taskable_type, $taskable_id)
    {
    	$property = $task->properties()->where('taskable_type',$taskable_type)->where('taskable_id',$taskable_id)->first();
    	
    	$property ->delete();
    	
    	return $this;
    }
    
}
