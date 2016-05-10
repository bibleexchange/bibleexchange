<?php namespace BibleExchange\Entities;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
 
class Userdetail extends Ardent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('users_id','userdetails_id','value');
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_details';
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');
	
	/**
	 *
	 *Register form Rules
	 *
	*/
		
	public static $rules = array(
    'users_id'=>'required|num|max:11',
    'userdetails_id'=>'required|num|max:11',
    'value'=>'required|alpha_num|max:64'
    );
	
	public function user()
  {
    return $this->belongsTo('User');
  }
	
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}	
	
}
