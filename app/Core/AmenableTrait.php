<?php namespace BibleExperience\Core;

trait AmenableTrait {

	public function amens()
	{
		return $this->morphMany('BibleExperience\Amen','amenable');
	}
    
    public function isAmenedBy(\BibleExperience\User $user)
    {

    	$amened = $this->amens
    				->where('user_id',$user->id)
    				->where('amenable_type',static::class)
    				->where('amenable_id',$this->id)->lists('id');
        if(count($amened) >= 1){
        	return true;
        }
        
    	return false;
    }
	
}