<?php namespace BibleExperience\Handlers\Commands;

use BibleExperience\Commands\UpdateProfileCommand;
use BibleExperience\UserRepository;
use BibleExperience\User;
use BibleExperience\Image;
use BibleExperience\Events\UserHasUpdatedProfile;

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