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
use BibleExperience\Viewer;
use Illuminate\Support\Collection;
use Auth, Event, stdClass;
use Tymon\JWTAuth\Exceptions\JWTException;

class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

  use PresentableTrait, FollowableTrait, Authenticatable, CanResetPassword;

    /**
     * Which fields may be mass assigned?
     *
     * @var array
     */
    protected $fillable = ['name','email','verified','role', 'password','remember_token','auth0id','nickname'];

	protected $appends = array('fullname','url','navHistory','token','lastStep','authenticated');
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

    public function notes()
    {
        return $this->hasMany('BibleExperience\Note');
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

    public function getNavHistoryAttribute()
    {
	//$nav = ['id'=>, 'url'=>'','title'=>''];
	$nav = ['id'=>1, 'url'=>'/bible/james_1','title'=>'James 1'];
	$nav2 = ['id'=>2, 'url'=>'/bible/james_4','title'=>'James 4'];
	$nav3 = ['id'=>3, 'url'=>'/course/24_the-book-of-romans/1?ref=romans_1','title'=>'The Book of Romans: Step 1'];

	$array[0] = $nav;
	$array[1] = $nav2;
	$array[2] = $nav3;

	return $array;
    }


      public static function createToken($email, $password)
      {
          $error = new stdClass;
          $user = new stdClass;
          try {
              // attempt to verify the credentials and create a token for the user
              if (! $token = JWTAuth::attempt(['email'=>$email, 'password'=>$password])) {
                  $error->message = 'invalid_credentials';
                  $error->code = 401;

                  return ['error'=>$error, 'token'=> $token, 'user'=> $user,'myNotes'=>collect([])];
              }
          } catch (JWTException $e) {
              // something went wrong whilst attempting to encode the token
              $error->message = 'could_not_create_token';
              $error->code = 500;
              return response()->json(['error'=>$error, 'token'=> $token, 'user'=> null,'myNotes'=>collect([])]);
          }
          // all good so return the token
          $user = static::where('email',$email)->first();

          return [
            'error'=> null,
            'token'=> $token,
            'user'=> $user,
            'myNotes'=>$user->notes
          ];
      }

    public static function signup($email, $password)
    {

       if (User::where('email',$email)->get()->count() < 1) {

		$confirmation_code = Hash::make($email);
	    	$user = new static(compact('email', 'password','confirmation_code'));
		$user->setPassword($password);
		$name = explode('@',$email)[0];
		$user->name = $name;
		$user->nickname = $name;
		$user->save();

		Event::fire('user.register', array($user));

	        // all good so return the token
        	return ['token'=>$user->getTokenAttribute(), 'error' => null, 'code'=>200, 'user'=> $user,'myNotes'=>$user->notes];


        } else {
	   return ['token'=>null, 'error' => 'email_taken', 'code'=>500, 'user'=> static::getGuest(),'myNotes'=>collect([])];
	}


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

    public function getAuthenticatedAttribute()
    {
      return Auth::check();
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

	if($this->id == null){
          return null;
	}else {
	  return JWTAuth::fromUser($this);
	}

    }

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

	public static function getGuest($error = null)
	{
	   $guest = new User;
	   $guest->id = null;
	   $guest->email = null;
	   $guest->name = null;
	   $guest->password = null;
	   $guest->token = null;
	   return $guest;

	}

  public static function getAuth($token = null){

        $a = new stdClass;
        $a->error = new stdClass;
        $a->token = null;
        $a->user = User::getGuest();
        $a->myNotes = collect([]);

        if($token !== null){
         $a->token = str_replace('Bearer ','', $token);

         if($a->token === "null" || $a->token === ""){$a->token = null;}
        }

           try {
            if($a->token === null){
                   $auth = \JWTAuth::parseToken();
                   $a->token = $auth->getToken();
            }else{
               $auth = \JWTAuth::setToken($a->token);
            }
           }catch(JWTException $e){
               $a->error->message= $e->getMessage();
               $a->error->code = $e->getCode();
               return $a;
           }

           try {

                   if (! $user = $auth->authenticate()) {
                        $a->error->message= 'user_not_found';
                        $a->error->code = 404;
                   }else{
                     $a->user = $user;
                      $a->error->message= 'Ok';
                      $a->error->code = 200;
                    }

               } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    $a->error->message= 'token_expired';
                    $a->error->code = $e->getStatusCode();
                } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    $a->error->message= 'token_invalid';
                    $a->error->code = $e->getStatusCode();
                } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                    $a->error->message= $e->getMessage();
                    $a->error->code = $e->getStatusCode();
                } finally {
                    if($a->error->code === 200){
                        $a->myNotes = $a->user->notes;
                    }
                    return $a;

                }

       }

}
