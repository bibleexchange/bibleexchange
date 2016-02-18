<?php namespace BibleExchange\Handlers\Events;

use BibleExchange\Events\UserAmenedObject;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class NotifyFollowersOfAmen {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Events  $event
	 * @return void
	 */
	public function handle(UserAmenedObject $event)
	{
		
		switch ($event->object_type)
		{
			case 'BibleExchange\Entities\Note':
				return $this->bibleNoteAmen($event->user, $event->object, $event->object_type);
				break;
			default:
				return null;
					
		}
	}
	
	public function bibleNoteAmen($sender, $note, $note_class){

		//Notify Note Creator if it isn't his own amen
		if ($sender->id !== $note->user->id)
		{
			$note->user->newNotification()
			->withSubject('Your Bible Note inspired an Amen!')
			->withBody('{user} said Amen! to your Bible note.')
			->withSender($sender->id)
			->regarding($note)
			->deliver();
		}
		
		//Notify Amen Senders Followers
		foreach ($sender->followers As $follower)
		{
			if($note->user->id === $follower->id){
				$owner = 'your';
			}else {
				$owner = $note->user->firstname.'&apos;s';
			}
			
			
			$follower->newNotification()
			->withSubject($sender->firstname.' said Amen! to this note.')
			->withBody('{user} said Amen! to '.$owner.' Bible note.')
			->withSender($note->user->id)
			->regarding($note)
			->deliver();
		}
		
	}
	
}
