<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\UnamenObjectCommand;

use BibleExperience\UserRepository;

class UnamenObjectCommandHandler {

    /**
     * @param UserRepository $repository
     */
    function __construct(UserRepository $repository)
    {

    }

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle(UnamenObjectCommand $command)
    {
    	$command->user->unamen($command->amenable_type, $command->amenable_id);
    }

}