<?php namespace BibleExperience\Users\Profiles\Events;

use BibleExperience\Entities\User;

class UserUpdatedProfile {

    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

} 