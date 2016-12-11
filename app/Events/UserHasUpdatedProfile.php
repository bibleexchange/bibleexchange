<?php namespace BibleExperience\Events;

use BibleExperience\User;

class UserHasUpdatedProfile {

    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

} 