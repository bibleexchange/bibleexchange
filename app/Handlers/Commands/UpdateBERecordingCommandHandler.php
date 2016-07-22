<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\UpdateBERecordingCommand;
use Illuminate\Queue\InteractsWithQueue;
use BibleExperience\Recording;

class UpdateBERecordingCommandHandler {
    
	function __construct()
    {

    }

	/**
	 * Handle the command.
	 *
	 * @param  UpdateBeRecordingCommand  $command
	 * @return void
	 */
	public function handle(UpdateBERecordingCommand $command)
	{
		
		$recording = $command->recording;
		$recording->date = $command->date;
		$recording->dated = $command->dated;
        $recording->description = $command->description; 
       	$recording->genre =  $command->genre;
		$recording->title = $command->title;
    	$recording->save();
        
        return $recording;
	}

}