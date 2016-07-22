<?php namespace BibleExperience;

class Site extends BaseModel {

  protected $hidden = ['created_at','updated_at'];
  protected $fillable = ['name', 'description', 'email', 'lang', 'create_lrs', 'registration', 'restrict', 'domain', 'super'];
  protected $rules = [
    'name' => 'required',
    'email' => 'required|unique'
  ];

  public function validate( $data ) {
    return Validator::make($data, $this->rules);
  }
}
