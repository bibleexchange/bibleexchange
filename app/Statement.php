<?php namespace BibleExperience;

use \BibleExperience\Helpers\Helpers;

class Statement extends BaseModel {

  protected $hidden = ['id', 'created_at', 'updated_at'];
  protected $fillable = ['statement', 'active', 'voided', 'refs', 'track_id','verb','user_id','activity_id'];
  protected $appends = [];

  public function track(){
    return $this->belongsTo('\BibleExperience\Track');
  }
  
  public function user(){
    return $this->belongsTo('\BibleExperience\User');
  }

  public function activity(){
    return $this->belongsTo('\BibleExperience\Activity');
  }
  
}
