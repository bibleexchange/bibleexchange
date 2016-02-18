<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\ChangePasswordCommand;
use BibleExchange\Events\UserPasswordWasChanged;
use BibleExchange\Entities\PasswordReset;
use BibleExchange\Entities\User;
use BibleExchange\Entities\UserRepository;
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
