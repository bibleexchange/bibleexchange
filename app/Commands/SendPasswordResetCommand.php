<?php namespace BibleExchange\Commands;

use BibleExchange\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendPasswordResetCommand extends Command implements ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;
	
	public $email;
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($email)
	{		
		$this->email = $email;
	}

}