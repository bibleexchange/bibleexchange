<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\UnamenObjectCommand;

use BibleExchange\Entities\UserRepository;

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