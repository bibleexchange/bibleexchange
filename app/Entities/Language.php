<?php namespace BibleExperience\Entities;

class Language extends \Eloquent {
	protected $fillable = ['name','code'];

public static $rules = array(
    'code'=> '',
    'name'=>''
    );

}