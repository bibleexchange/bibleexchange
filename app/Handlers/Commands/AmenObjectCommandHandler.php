<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\AmenObjectCommand;
use BibleExperience\Events\UserAmenedObject;
use BibleExperience\Amen;
use Illuminate\Queue\InteractsWithQueue;

class AmenObjectCommandHandler {

    /**
     * @param UserRepository $repository
     */
    function __construct(\BibleExperience\Amen $amen)
    {
		$this->model = $amen;
    }

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle(AmenObjectCommand $command)
    {
    	$amen = $this->model->amenThis($command->user, $command->amenable_type, $command->amenable_id);
    	
    	\Event::fire(new UserAmenedObject($command->user, $command->amenable_type, $command->amenable_id));
    	 
        return $amen;
    }

}