<?php namespace BibleExperience\Helpers;

use \BibleExperience\Lrs as LrsModel;
use \BibleExperience\Site;

class Lrs {

  /**
  * @param $role  Can the current user create LRS based on their role?
  *
  * @return boolean
  **/
  public static function lrsCanCreate(){

    $site = Site::first();

    if( \Auth::user()->can("CREATE_LRS")){
      return true;
    }
    
    return false;
    
  }

  /**
  * @param $lrs  Can the current user access based on passed role requirement
  *
  * @return boolean
  **/
  public static function lrsAdmin( $lrs ){

    $user = \Auth::user();

    //get all users with access to the lrs
    foreach( $lrs->members as $u ){
      $get_users[] = $u['_id'];
    }
   
    //check current user is in the list of allowed users and is an admin
    if( !in_array($user->id, $get_users) && $user->role == 'admin' ){
      return true;
    }
    
    return false;
    
  }

  /**
  * @param $lrs  Can the current user edit lrs
  *
  * @return boolean
  **/
  public static function lrsEdit( $lrs ){

    //check current user is in the list of allowed users and can edit lrs
	return \Auth::user()->can("EDIT_LRS",$lrs->id);

  }

  /**
   * Is user the owner of LRS (or site super admin)
   *
   * @return boolean
   *
   **/
  public static function lrsOwner( $lrs_id ){
    $lrs = LrsModel::find( $lrs_id );
    if( $lrs->owner_id == \Auth::user()->id || \Auth::user()->role == 'super' ){
      return true;
    }else{
      return false;
    }
  }

  /**
   * Is a user, a member of an LRS?
   *
   * @param $string $lrs
   * @param $string $user
   *
   * @return boolean
   *
   **/
  public static function isMember($lrs, $user){	  
    $isMember = LrsModel::where('users.id', $user)->where('id', $lrs)->first();
    if( $isMember ){
      return true;
    }
    return false;
  }

  	public function can($request)
	{
		
		foreach($this->roles->permisions AS $permission){
			if($permission == $request) {
				return true;
			}
		}
	
		return false;
	}

}