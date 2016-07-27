<?php namespace BibleExperience;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends BaseModel {

	protected $fillable = ['user_id','token'];

}
