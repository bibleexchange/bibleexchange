<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\ChangePasswordCommand;
use BibleExperience\Events\UserPasswordWasChanged;
use BibleExperience\PasswordReset;
use BibleExperience\User;
use BibleExperience\UserRepository;
use Illuminate\Queue\InteractsWithQueue;

class ChangePasswordCommandHandler {

	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Handle the command.
	 *
	 * @param  ChangePasswordCommand  $command
	 * @return void
	 */
	public function handle(ChangePasswordCommand $command)
	{		
		$command->user->setPasswordAttribute($command->newPassword);
		$this->repository->save($command->user);

		\Event::fire(new UserPasswordWasChanged($command->user));
		
	}

}
