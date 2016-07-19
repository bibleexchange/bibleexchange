<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\CreateBERecordingCommand;

use Illuminate\Queue\InteractsWithQueue;

use BibleExperience\Entities\Recording;

class CreateBERecordingCommandHandler {

    /**
     * @var UserRepository
     */


    /**
     * @param UserRepository $repository
     */
    function __construct()
    {
 
    }

	/**
	 * Handle the command.
	 *
	 * @param  CreateLessonCommand  $command
	 * @return void
	 */
	public function handle(CreateBERecordingCommand $command)
	{

		$recording = Recording::make(
				$command->date,
				$command->dated,
           		$command->description, 
           		$command->genre,
				$command->title
        );

    	$recording->save();

        return $recording;
	}

}