<?php

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

		$register_data = new \EzForm("POST","http://localhost/register", $fields); 
        return $register_data;
    }
	
}