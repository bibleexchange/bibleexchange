<?php namespace BibleExperience;

class Member extends BaseModel {
	
  protected $fillable = ['lrs_id', 'user_id', 'role_id'];

  protected $table = "lrs_user";
  
  public function user() {
    return $this->belongsTo('User','user_id');
  }
  
  public function lrs() {
    return $this->belongsTo('Lrs','lrs_id');
  }
  
  public function role() {
    return $this->belongsTo('Role','role_id');
  }

}