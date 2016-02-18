<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;
use BibleExchange\Entities\User;

class Amen extends Model {

	protected $fillable = ['user_id','amenable_id','amenable_type','created_at','updated_at'];
	
		private $relatedObject = null;
	
    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
 
    public function user()
    {
        return $this->belongsTo('BibleExchange\Entities\User');
    }
    
    public function amenable()
    {
    	return $this->morphTo();
    }
    
    public function regarding($object)
    {
    	if(is_object($object))
    	{
    		$this->amenable_id   = $object->id;
    		$this->amenable_type = get_class($object);
    	}
    
    	return $this;
    }
    
    public function hasValidObject()
    {
    	try
    	{
    		$object = call_user_func_array($this->amenable_type . '::findOrFail', [$this->amenable_id]);
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
    			throw new \Exception(sprintf("No valid object (%s with ID %s) associated with this amen.", $this->object_type, $this->object_id));
    		}
    	}
    
    	return $this->relatedObject;
    }

    public function amenThis(User $userAmening, $amenable_type, $amenable_id)
    {
    	
    	$amen = $userAmening->amens()->create(['user_id' => $userAmening->id, 'amenable_type'=>$amenable_type,'amenable_id'=>$amenable_id])->save();
    	
    	return $amen;
    }
    
    /**
     * Unfollow a BibleExchange user.
     *
     * @param $userIdToUnfollow
     * @param User $user
     * @return mixed
     */
    public function unamenThis(User $userAmening, $amenable_type, $amenable_id)
    {
    	$amen = $userAmening->amens()->where('amenable_type',$amenable_type)->where('amenable_id',$amenable_id)->first();
    	
    	$amen->delete();
    	
    	return $this;
    }
    
}
