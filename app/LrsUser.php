<?php namespace BibleExperience;

class LrsUser extends BaseModel {
  public $timestamps = false;
  protected $table = 'lrs_user';
  protected $fillable = ['lrs_id', 'user_id', 'role_id'];
  
  public function lrs() {
    return $this->belongsTo('\BibleExperience\Lrs');
  }
  
  public function member() {
    return $this->belongsTo('\BibleExperience\User');
  }
  
  public function role() {
    return $this->belongsTo('\BibleExperience\Role');
  }
  
}