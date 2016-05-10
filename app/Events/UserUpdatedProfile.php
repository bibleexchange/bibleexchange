<?php namespace BibleExchange\Users\Profiles\Events;

use BibleExchange\Entities\User;

class UserUpdatedProfile {

    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

} 