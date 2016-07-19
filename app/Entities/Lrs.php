<?php

class Lrs extends Model {
	
  protected $collection = 'lrs';
  protected $fillable = ['title', 'description', 'owner_id'];

  /**
   * Validation rules for statement input
   **/
  protected $rules = array('title' => 'required');

  public function validate( $data ) {
    return Validator::make($data, $this->rules);
  }
  
  public function members() {
    return $this->hasMany('Member');
  }
  
}