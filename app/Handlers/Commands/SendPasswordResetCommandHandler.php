<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\SendPasswordResetCommand;
use BibleExchange\Events\UserRequestedPasswordReset;
use Illuminate\Queue\InteractsWithQueue;
use BibleExchange\Entities\PasswordReset;
use BibleExchange\Entities\UserRepository;

class SendPasswordResetCommandHandler {
	
	private $repository;
	
	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle the command.
	 *
	 * @param  CreateBibleNoteCommand  $command
	 * @return void
	 */
	public function handle(SendPasswordResetCommand $command)
	{

		$user = UserRepository::findByEmail($command->email);
		
		$user_id = $user->id;
		$token = \Hash::make($user->email);
		
		PasswordReset::create(compact('user_id','token'));
		
		\Event::fire(new UserRequestedPasswordReset($user));
		
		return $user;
	}
}
