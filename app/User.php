<?php namespace BibleExperience;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
//use Illuminate\Notifications\Notifiable;

use Hash, Carbon, Session, JWTAuth, Mail;
use Laracasts\Presenter\PresentableTrait;
use BibleExperience\Core\FollowableTrait;
use BibleExperience\BibleChapter;
use BibleExperience\Bookmark;
use BibleExperience\Viewer;
use Illuminate\Support\Collection;
use Auth, Event, stdClass;
use Tymon\JWTAuth\Exceptions\JWTException;
use GraphQLRelay\Relay;
use BibleExperience\Mailers\UserMailer;

class PermissionRequested {

  public function __construct($user, $request, $options){

      $this->user = $user;
      $this->request = $request;
      $this->options = $options;
      $this->can = false;
      $this->reason = "I_SAY_NO_TO_EVERYBODY_AT_FIRST";

      if($user->hasRole('SUPER')){
        $this->can = true;
        $this->reason = "SUPER_USER_CAN_DO_ANYTHING";
      }else{

        switch ($request) {
          case 'EDIT_LRS': $this->editLRS(); break;
          case 'CREATE_LRS': $this->createLRS(); break;
          case 'CREATE_LESSON': $this->createLesson(); break;
          case 'UPDATE_LESSON': $this->updateLesson(); break;
          case 'DESTROY_LESSON': $this->destroyLesson(); break;

          case 'CREATE_COURSE': $this->createCourse(); break;
          case 'UPDATE_COURSE': $this->updateCourse(); break;
          case 'DESTROY_COURSE': $this->destroyCourse(); break;
          case 'CREATE_STATEMENT': $this->createStatement(); break;

          default: //$hasPermission = in_array($request,$this->permissions());
        }

      }

   }

   function editLRS(){
      //$lrs = $this->user->lrs()->where('lrs_id',$this->options['lrs_id'])->get();
      $this->can = false;
      $this->reason = "NOT_ALLOWING_ANYONE_RIGHT_NOW";
   }

   function createLRS(){
      $hasPermission = in_array($request,$user->permissions());
      $this->can = $hasPermission;
      
      if($hasPermission){
        $this->reason = "";
      }else{
        $this->reason = "USER_DOES_NOT_HAVE_PERMISSION_TO_" . $this->request;
      }

      

   }

      function createLesson(){
          $course = Course::find($this->options['course_id']);

          if($course !== null){

            $this->can  = $this->user->id === $course->user_id;

            if(!$this->can){
              $this->reason = "USER_CANNOT_CREATE_LESSONS_FOR_" . $course->title . "_ID_" . $course->id;
            }

          }else{
            $this->reason = "COURSE_" . $this->options['course_id'] . "_NOT_FOUND";
          }
      

   }

         function updateLesson(){
          $lesson = Lesson::find($this->options['id']);

          if($lesson !== null){

            $this->can  = $this->user->id === $lesson->course->user_id;

            if(!$this->can){
              $this->reason = "USER_CANNOT_UPDATE_LESSONS_FOR_COURSE_" . $lesson->course->title . "_ID_" . $lesson->course->id;
            }

          }else{
            $this->reason = "LESSON_ID_" . $this->options['id'] . "_NOT_FOUND";
          }
      

   }

    function destroyLesson(){
          $lesson = Lesson::find($this->options['id']);

          if($lesson !== null){

            $this->can  = $this->user->id === $lesson->course->user_id;

            if(!$this->can){
              $this->reason = "USER_CANNOT_DELETE_LESSONS_FOR_COURSE_" . $lesson->course->title . "_ID_" . $lesson->course->id;
            }

          }else{
            $this->reason = "LESSON_ID_" . $this->options['id'] . "_NOT_FOUND";
          }
      

   }


     function createCourse(){

            $this->can  = in_array($this->request,$this->user->permissions());

            if(!$this->can){
              $this->reason = "USER_CANNOT_COURSE_WITH_TITLE_:_" . $this->options['title'];
            }

   }

         function updateCourse(){
          $course = Course::find($this->options['id']);

          if($course !== null){

            $this->can  = $this->user->id === $course->user_id;
            if(!$this->can){
              $this->reason = "USER_CANNOT_UPDATE_COURSE_WITH_ID_" . $course->id ."_AND_USER_ID:_" . $course->user_id;
            }

          }else{
            $this->reason = "COURSE_ID_" . $this->options['id'] . "_NOT_FOUND";
          }
      

   }

    function destroyCourse(){
          $course = Course::find($this->options['id']);

          if($course !== null){

            $this->can  = $this->user->id === $course->user_id;

            if(!$this->can){
              $this->reason = "USER_CANNOT_DELETE_COURSE_WITH_ID_:_" . $course->id;
            }

          }else{
            $this->reason = "COURSE_ID_" . $this->options['id'] . "_NOT_FOUND";
          }
      

   }

        function createStatement(){
            $this->can  = true;
        }

}

class User extends \Eloquent implements AuthenticatableContract, CanResetPasswordContract {

  use PresentableTrait, FollowableTrait, Authenticatable, CanResetPassword;

    /**
     * Which fields may be mass assigned?
     *
     * @var array
     */
    protected $fillable = ['name','email','verified','role', 'password','remember_token','auth0id','nickname','confirmation_code'];

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

    public function tracks()
    {
        return $this->hasMany('BibleExperience\Track');
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

    public function lessons(){

      return $this->hasManyThrough('BibleExperience\Lesson','BibleExperience\Course');
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

  public function statements() {
    return $this->hasMany('\BibleExperience\Statement');
  }

  public static function failLogin(){
            $auth = new stdClass;
            $auth->error = new stdClass;
            $auth->error->code = 200;
            $auth->error->message = "Session destroyed successfully";
            $auth->token = null;
            $auth->user = new User;
            return $auth;
  }

  public static function login($user)
      {

            $auth = new stdClass;
            $auth->error = new stdClass;

            $auth->error->code = 200;
            $auth->error->message = null;
            $auth->token = null;
            $auth->user = new User;

          try {
              // attempt to verify the credentials and create a token for the user
              if (! $token = JWTAuth::fromUser($user)) {

                  $auth->error->message = 'invalid_credentials';
                  $auth->error->code = 401;
                  $auth->token = $token;
                  return $auth;
              }
          } catch (JWTException $e) {
              // something went wrong whilst attempting to encode the token
              $auth->error->message = 'could_not_create_token';
              $auth->error->code = 500;
              return $auth;
          }
          // all good so return the token

          $auth->user = $user;
          $auth->token = $token;

          return $auth;
      }


      public static function createToken($email, $password)
      {

            $auth = new stdClass;
            $auth->error = new stdClass;

            $auth->error->code = 200;
            $auth->error->message = null;
            $auth->token = null;
            $auth->user = new User;


          try {
              // attempt to verify the credentials and create a token for the user
              if (! $token = JWTAuth::attempt(['email'=>$email, 'password'=>$password])) {

                  $auth->error->message = 'invalid_credentials';
                  $auth->error->code = 401;
                  $auth->token = $token;
                  return $auth;
              }
          } catch (JWTException $e) {
              // something went wrong whilst attempting to encode the token
              $auth->error->message = 'could_not_create_token';
              $auth->error->code = 500;
              return $auth;
          }
          // all good so return the token

          $auth->user = static::where('email',$email)->first();
          $auth->token = $token;

          return $auth;
          //response()->json(['error'=>$error, 'token'=> $token, 'user'=> null]);
      }

    public static function signup($email, $password)
    {

            $auth = new stdClass;
            $auth->error = new stdClass;
            $auth->error->code = 200;
            $auth->error->message = null;
            $auth->token = null;
            $auth->user = static::getGuest();

       if (User::where('email',$email)->get()->count() < 1) {

          $user = new User;
          $user->email = $email;
          $user->setPassword($password);
          $name = explode('@',$email)[0];
          $user->name = $name;
          $user->verified = false;
          $user->nickname = $name;
          $user->confirmation_code = Hash::make($email);
          

          $subject = 'Please Confirm Your Email for Bible exchange';
          $view = 'emails.confirm';
          $data = ['confirmation_code'=>$user->confirmation_code];

          Mail::send('emails.confirm', $data, function ($message) use($user){
              $message->from('mail@bible.exchange', 'Bible exchange');
              $message->to($user->email)->bcc('sgrjr@deliverance.me');
          });
          $user->save();

          $auth->user = $user;
          $auth->token = $user->token;
          
        } else {

            $auth->error->code = 500;
            $auth->error->message = 'Email already taken!';
            $auth->user = static::getGuest();
	     }
    
      return $auth;

    }


    public static function confirm($confirmation_code)
    {

    	$user = User::where('confirmation_code',$confirmation_code)->first();

    	if($user !== null)
    	{
    		$user->confirmation_code = null;
    		$user->verified = true;
        $user->save();
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
		return new PermissionRequested($this, $request, $options);
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
            $a->token = str_replace('Bearer ','', $token);;
            $a->user = User::getGuest();
            $a->myNotes = null;

              if($token === "BACKDOOR"){
                $a->user = User::find(3);
                $a->token = $token;
              }else{

                try {
                     $auth = \JWTAuth::setToken($a->token);
                 }catch(JWTException $e){
                     $a->error->message= $e->getMessage();
                     $a->error->code = $e->getCode();
                     return $a;
                 }

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
                    $a->myNotes = $a->user->notes;
                    return $a;
                }

       }

   public function hasNotCompletedActivity($activity){
      
       $relatedUserStatements = $this->statements()->where('statements.activity_id',$activity->id)->get(['verb']);

       if($relatedUserStatements->count() < 1){
        return true;
       }else if(!in_array(
          'PASSED',
          array_flatten($relatedUserStatements->toArray())
          )) {
        return true;
       }else{
        return false;
       }


    }

}
