<?php namespace BibleExperience;

class Email extends \Eloquent {
	protected $fillable = ['from','body','updated_at','created_at'];
}