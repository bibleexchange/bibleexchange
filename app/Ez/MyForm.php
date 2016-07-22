<?php namespace BibleExperience\Ez;

use BibleExperience\Ez\EzForm;

class MyForm {

	public function register()
    {
		$fields = [
			["type"=>"text", "name"=>"name", "label"=>"Name", "required"=>"1"],
			["type"=>"email", "name"=>"email", "label"=>"Email", "required"=>"1"],
			["type"=>"password", "name"=>"password", "label"=>"Password", "required"=>"1"],
			["type"=>"password", "name"=>"password_confirmation", "label"=>"Password&nbsp;confirm", "required"=>"1"],
			["type"=>"submit", "value"=>"Submit"]
		];

		$register_data = new EzForm("POST","/register", $fields, "Register"); 
        return $register_data;
    }
	
	public function login()
    {
		$fields = [
			["type"=>"email", "name"=>"email", "label"=>"Email", "required"=>"1"],
			["type"=>"password", "name"=>"password", "label"=>"Password", "required"=>"1"],
			["type"=>"submit", "value"=>"Submit"]
		];

		$register_data = new EzForm("POST","/login", $fields, "Login"); 
        return $register_data;
    }
	
}