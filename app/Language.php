<?php namespace BibleExperience;

class Language extends \Eloquent {
	protected $fillable = ['name','code'];

public static $rules = array(
    'code'=> '',
    'name'=>''
    );

}