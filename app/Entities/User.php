<?php namespace BibleExperience\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash, Carbon, Session, JWTAuth;
use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\FollowableTrait;
use BibleExperience\Entities\BibleChapter;
use BibleExperience\Entities\Bookmark;

use Illuminate\Support\Collection;

class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use PresentableTrait, FollowableTrait, Authenticatable, CanResetPassword;

    /**
     * Which fields may be mass assigned?
     *
     * @var array
     */
    protected $fillable = ['firstname','middlename','lastname','suffix', 'username','twitter','profile_image','gender','email', 'password','confirmation_code', 'confirmed','active'];
	
    public $adminTableHeaders = ['firstname','middlename','lastname','suffix', 'username','twitter','profile_image','gender','email', 'password','confirmation_code', 'confirmed','active'];
    
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
        return $this->hasMany('BibleExperience\Entities\Note')->latest();
    }
    
    
    
    public function coCourses()
    {
    	return $this->belongsToMany('BibleExperience\Entities\Course', 'course_user', 'user_id', 'course_id');
    }
    
	public function courses()
    {
    	return $this->hasMany('BibleExperience\Entities\Course');
    }
	
    public function studies(){
    	
    	return $this->hasMany('BibleExperience\Entities\Study','user_id')->orderBy('updated_at','DESC');
    }
    
    public function studiesNotUsedList($array = [null]){
    	return $this->studies()->whereNotIn ( 'id', $array )->get()->lists('title','id');
    }
    
    public function answers(){
    	 
    	return $this->hasMany('BibleExperience\Entities\Answer','user_id');
    }
    
    public function highlights(){
    
    	return $this->hasMany('BibleExperience\Entities\BibleHighlight','user_id');
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
        return $this->hasMany('BibleExperience\Entities\Comment');
    }
	
    public function bookmarks()
    {
    	return $this->hasMany('BibleExperience\Entities\Bookmark');
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

    	return $this->hasMany('\BibleExperience\Entities\PasswordReset')
    		->whereBetween('created_at', [$fromDate, $tillDate])->first();
    }
    
    /*Notifications */
    
    public function notifications()
    {
    	return $this->hasMany('BibleExperience\Entities\Notification');
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
    	return $this->hasMany('BibleExperience\Entities\Amen');
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
	return $this->hasMany('Lrs','owner_id');
  }
  
  public function roles()
  {		
	return $this->belongsToMany('Role');
		
  }

	public function permissions()
	{		
	  $permissions = [];
	  
	  foreach($this->roles AS $role){
		  $permissions += $role->permissions->lists('name','id');
	  }
	  
	  return Collection::make($permissions);		
	}
	
  public function hasRole($role)
	{
	   If ($this->roles()->where('name','=',$role)->first()) return true;
	   
	   return false;
	}
  
	public function can($request, $options = false)
	{
		
		$hasPermission = in_array($request,$this->permissions()->toArray());
		
		switch($request){
			case "EDIT_LRS":
				
				if($hasPermission){
					$lrs = Lrs::find($options)->where("user_id",Auth::user()->id)->get();
					dd($lrs->count());
					if($lrs->count() >= 1){
						return true;
					}else{
						return false;
					}
					
				}else{
					return false;
				}
				
			break;
			
			default:
				return $hasPermission;
		}
	
	}
	
}
