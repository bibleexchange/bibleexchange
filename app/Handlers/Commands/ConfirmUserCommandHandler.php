<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\ConfirmUserCommand;
use Illuminate\Queue\InteractsWithQueue;
use BibleExchange\Entities\UserRepository;
use BibleExchange\Entities\User;
use BibleExchange\Events\UserHasConfirmedEmail;

class ConfirmUserCommandHandler {
	
	private $userRepository;
	
	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CreateBibleNoteCommand  $command
	 * @return void
	 */
	public function handle(ConfirmUserCommand $command)
	{
	
		$user = User::confirm($command->confirmation_code);
		
		if($user !== null)
		{
			$this->userRepository->save($user);

			\Event::fire(new UserHasConfirmedEmail($user));
		}
		return $user;
	}
}
