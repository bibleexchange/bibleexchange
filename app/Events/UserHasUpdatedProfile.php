<?php namespace BibleExchange\Events;

use BibleExchange\Entities\User;

class UserHasUpdatedProfile {

    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

} 