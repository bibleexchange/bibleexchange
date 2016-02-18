<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class UrlShort extends Model {

		protected $fillable = ['url','shortable_id','shortable_type','created_at','updated_at'];
	
		private $relatedObject = null;
	
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
    
    public function shortable()
    {
    	return $this->morphTo();
    }
	
    public function regarding($object)
    {
    	if(is_object($object))
    	{
    		$this->shortable_id   = $object->id;
    		$this->shortable_type = get_class($object);
    	}
    
    	return $this;
    }
    
    public function hasValidObject()
    {
    	try
    	{
    		$object = call_user_func_array($this->shortable_type . '::findOrFail', [$this->shortable_id]);
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
    			throw new \Exception(sprintf("No valid object (%s with ID %s) associated with this url.", $this->object_type, $this->object_id));
    		}
    	}
    
    	return $this->relatedObject;
    }

    public function shortThis($shortable_type, $shortable_id, $shortUrl = null)
    {
    	
		if($shortUrl === null){
			$shortUrl = str_replace('BibleExchange\\Entities\\',$shortable_type).$shortable_id;
		}
		
    	$short = UrlShort::create(['user_id' => $userAmening->id, 'shortable_type'=>$shortable_type,'shortable_id'=>$shortable_id]);
    	
    	return $short;
    }

}
