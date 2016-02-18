<?php namespace BibleExchange\Entities;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {

	protected $fillable = ['user_id','token'];

}
