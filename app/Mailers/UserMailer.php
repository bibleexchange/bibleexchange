<?php namespace BibleExchange\Mailers;

use BibleExchange\Entities\User;

class UserMailer extends Mailer {

    public function sendConfirmMessageTo(User $user)
    {
    	
    	$subject = 'Please Confirm Your Email for Bible exchange';
    	$view = 'emails.confirm';
    	$data = ['confirmation_code'=>$user->confirmation_code];

    	return $this->sendTo($user, $subject, $view, $data);
    }

    public function sendWelcomeMessageTo(User $user)
    {    	
    	$subject = 'Welcome to Bible exchange!';
    	$view = 'emails.welcome';
    	$data = [];
    
    	return $this->sendTo($user, $subject, $view, $data);
    }
    
    public function sendResetPasswordMessageTo(User $user)
    {

    	$subject = 'Did you ask to reset your Bible exchange password?';
    	$view = 'emails.passwordreset';
    	$data = ['user'=>$user, 'token'=>$user->passwordReset()->token];

    	return $this->sendTo($user, $subject, $view, $data);
    }
    
    public function sendPasswordChangedMessageTo(User $user)
    {
    
    	$subject = 'Your Bible exchange password was successfully changed.';
    	$view = 'emails.passwordchanged';
    	$data = ['user'=>$user];
    
    	return $this->sendTo($user, $subject, $view, $data);
    }
    
}

