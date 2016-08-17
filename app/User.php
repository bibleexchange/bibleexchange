<?php namespace BibleExperience;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash, Carbon, Session, JWTAuth;
use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\FollowableTrait;
use BibleExperience\BibleChapter;
use BibleExperience\Bookmark;
use Illuminate\Support\Collection;

class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use PresentableTrait, FollowableTrait, Authenticatable, CanResetPassword;

    /**
     * Which fields may be mass assigned?
     *
     * @var array
     */
    protected $fillable = ['name','email','verified','role', 'password','remember_token'];
    
	protected $appends = array('fullname','url','recentChaptersRead','token','lastStep');
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

    /**
     * Path to the presenter for a user.
     *
     * @var string
     */
    protected $presenter = 'BibleExperience\Presenters\UserPresenter';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    /**
     * Passwords must always be hashed.
     *
     * @param $password
     */
    public function setPassword($password)
    {
    	return $this->attributes['password'] = Hash::make($password);
    }
    
    /**
     * A user has many notes.
     *
     * @return mixed
     */
    public function notes()
    {
        return $this->hasMany('BibleExperience\Note')->latest();
    }
    
    public function coCourses()
    {
    	return $this->belongsToMany('BibleExperience\Course', 'course_user', 'user_id', 'course_id');
    }
    
	public function courses()
    {
    	return $this->hasMany('BibleExperience\Course');
    }
	
    public function studies(){
    	
    	return $this->hasMany('BibleExperience\Study','user_id')->orderBy('updated_at','DESC');
    }
    
    public function studiesNotUsedList($array = [null]){
    	return $this->studies()->whereNotIn ( 'id', $array )->get()->lists('title','id');
    }
    
    public function answers(){
    	 
    	return $this->hasMany('BibleExperience\Answer','user_id');
    }
    
    public function highlights(){
    
    	return $this->hasMany('BibleExperience\BibleHighlight','user_id');
    }
    
    public function recentLessonEdited()
    {
    	return $this->lessons()->orderBy('updated_at','DESC')->first();
    }
    
	public function getrecentChaptersReadAttribute()
    {
		
		$array = [];
		
		if(Session::has('recent_bible_read'))
    	$array = Session::get('recent_bible_read');
		
		return $array;
    }
	
    public static function register($email, $password)
    {
        $confirmation_code = Hash::make($email);
    	
    	$user = new static(compact('email', 'password','confirmation_code'));

        return $user;
    }
	
    public static function confirm($confirmation_code)
    {
    	
    	$user = User::where('confirmation_code',$confirmation_code)->first();
    	
    	if($user !== null)
    	{
    		$user->confirmation_code = null;
    		$user->confirmed = 1;
    	}
    	
    	return $user;
    
    }
    
    public static function updateProfile($firstname,$middlename,$lastname,$suffix,$gender,$profile_image,$location)
    {

    	$user = \Auth::user();
    	
    	$user->username = strtolower($firstname).'-'.strtolower($middlename).'-'.strtolower($lastname).strtolower($suffix);
    	$user->firstname = $firstname;
    	$user->middlename = $middlename;
    	$user->lastname = $lastname;
    	$user->suffix = $suffix;
    	$user->gender = $gender; 

    	if($profile_image !== null){    		
    		$user->profile_image = $profile_image;
    	}
    	
    	$user->location = $location;
    	 
    	return $user;
    }
    
    /**
     * Determine if the given user is the same
     * as the current one.
     *
     * @param  $user
     * @return bool
     */
    public function is($user)
    {
        if (is_null($user)) return false;

        return $this->username == $user->username;
    }
    
    public function isSetup()
    {
    	if ($this->username !== null) return true;
    
    	return false;
    }
	
    public function isConfirmed()
    {
    	if ($this->confirmed > 0) return true;
    
    	return false;
    }
    

	

	
    public function comments()
    {
        return $this->hasMany('BibleExperience\Comment');
    }
	
    public function bookmarks()
    {
    	return $this->hasMany('BibleExperience\Bookmark');
    }
    
	public function transcripts()
    {
        return $this->hasMany('Transcript','user_id');
    }
	
	public function joined()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }
	
    public function profileURL()
    {
    	return url('/@'.$this->username);
    }
    
	public function profileImage()
    {
        return NULL;
    }
	
	public function getFullnameAttribute()
    {
        return $this->firstname.' '.$this->middlename.' '.$this->lastname.' '.$this->suffix;
    }
	
	public function getLastStepAttribute()
    {
        return Step::find(1);
    }
	 
	public function transcriptInfo()
    {
        $transcripts = \DB::table('transcripts')->where('user_id',$this->id);
		//careerGPA, careerCredits
		
		$a = new \stdClass();		
		$a->count = $transcripts->count();
		
		$a->careerGPA = $transcripts->avg('percentage') / 25;
		$a->careerGPA = round($a->careerGPA,2);

		$a->careerCredits =$transcripts->sum('credits_attempted');
		
		return $a;
		
    }
       
    public function passwordReset()
    {
    	$fromDate = \Carbon::now()->subDays(3);
    	$tillDate = \Carbon::now();

    	return $this->hasMany('\BibleExperience\PasswordReset')
    		->whereBetween('created_at', [$fromDate, $tillDate])->first();
    }
    
    /*Notifications */
    
    public function notifications()
    {
    	return $this->hasMany('BibleExperience\Notification');
    }
    
    public function newNotification()
    {
    	$notification = new Notification;
    	$notification->user()->associate($this);
    
    	return $notification;
    }
    
	public function newBookmark()
    {
    	$bookmark = new Bookmark;
    	$bookmark->user()->associate($this);
    
    	return $bookmark;
    }
    
    public function amens()
    {
    	return $this->hasMany('BibleExperience\Amen');
    }
  
    
    public function unamen($amenable_type, $amenable_id)
    {
    	
    	$this->amens()
    		->where("amenable_type", $amenable_type)
    		->where("amenable_id", $amenable_id)->delete();

    	return $this;
    }
    
    public function getUrlAttribute(){
    	return url('/@'.$this->username);
    }
	
	public function getTokenAttribute(){
    	return JWTAuth::fromUser($this);
    }
	
  public function getAuthIdentifier() { return $this->getKey(); }
  public function getAuthPassword() { return $this->password; }
  public function getReminderEmail() { return $this->email; }
  public function getRememberToken() { return $this->remember_token; }
  public function setRememberToken($value) { $this->remember_token = $value; }
  public function getRememberTokenName() { return 'remember_token'; }
  
  public function lrs() {
	return $this->belongsToMany('\BibleExperience\Lrs');
  }
  
  public function roles()
  {		
	return $this->belongsToMany('\BibleExperience\Role');	
  }

	public function permissions()
	{		
	  $permissions = [];

	  foreach($this->roles AS $role){

		  foreach($role->permissions AS $p){
			  $permissions[$p->name] = $p->name;
		  }
	  }

	  return $permissions;		
	}
	
	public function hasRole($role)
	{
	   If ($this->roles()->where('name','=',$role)->first()) return true;
	   
	   return false;
	}
  
	public function can($request, $options = false)
	{
		if($this->hasRole('SUPER')){
			return true;
		}
		
		switch ($request) {
			case 'EDIT_LRS':
				$lrs = $this->lrs()->where('lrs_id',$options['lrs_id'])->get();
				dd($lrs);
				$hasPermission = false;
				break;
			case 'CREATE_LRS':
				$hasPermission = in_array($request,$this->permissions());
				break;

			default:
				$hasPermission = in_array($request,$this->permissions());	
		}
		
		return $hasPermission;
	}
	
}