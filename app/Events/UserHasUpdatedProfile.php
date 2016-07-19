<?php namespace BibleExperience\Events;

use BibleExperience\Entities\User;

class UserHasUpdatedProfile {

    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

} 