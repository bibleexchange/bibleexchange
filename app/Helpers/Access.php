<?php namespace BibleExperience\Helpers;

class Access {

  /**
   * Check user is a certain role.
   *
   * @param $role  String  The role to match logged in user against
   *
   **/
  public static function isRole( $role ){
	if(\Auth::check()){
		return \Auth::user()->hasRole($role);
	}
    return false;
  }

}