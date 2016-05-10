<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldBeQueued;

class RegisterUserCommand extends Command{

	use InteractsWithQueue, SerializesModels;
	
    public $email;

    public $password;
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */

    function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

} 