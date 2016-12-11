<?php namespace BibleExperience\Commands;

use BibleExperience\Commands\Command;
use BibleExperience\User;

class ChangePasswordCommand extends Command {
	
	public $user;
	public $newPassword;
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, $newPassword)
	{
		$this->user = $user;
		$this->newPassword = $newPassword;
	}

}
