<?php namespace BibleExchange\Commands;

class UpdateProfileCommand {

    public $firstname, $middlename, $lastname, $suffix, $gender, $profile_image, $location;
    
    function __construct($firstname, $middlename, $lastname, $suffix, $gender, $profile_image, $location)
    {
        $this->firstname = $firstname;
        $this->middlename = $middlename;
        $this->lastname = $lastname;
        $this->suffix = $suffix;
        $this->gender = $gender;    
        $this->profile_image = $profile_image;
        $this->location = $location;
    }

} 