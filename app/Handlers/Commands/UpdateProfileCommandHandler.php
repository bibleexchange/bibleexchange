<?php namespace BibleExchange\Handlers\Commands;

use BibleExchange\Commands\UpdateProfileCommand;
use BibleExchange\Entities\UserRepository;
use BibleExchange\Entities\User;
use BibleExchange\Entities\Image;
use BibleExchange\Events\UserHasUpdatedProfile;

class UpdateProfileCommandHandler {
	
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
	public function handle(UpdateProfileCommand $command)
	{
		
		$user = User::updateProfile(
				$command->firstname, $command->middlename, $command->lastname, $command->suffix, $command->gender, $command->profile_image, $command->location
		);
		
		$this->userRepository->save($user);

		\Event::fire(new UserHasUpdatedProfile($user));

		return $user;
	}
	
}