<?php namespace BibleExchange\Events;

use BibleExchange\Events\Event;
use BibleExchange\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserAmenedObject extends Event {

	use SerializesModels;
	
	public $user, $oject;
	
	
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, $object_type, $object_id)
	{
		$this->user = $user;
		
		$objects = new $object_type;		
		$this->object = $objects->find($object_id);
		$this->object_type = $object_type;
	}

}
