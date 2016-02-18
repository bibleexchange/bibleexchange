<?php namespace BibleExchange\Commands;

class UnfollowUserCommand {

    /**
     * @var
     */
    public $userId;

    /**
     * @var
     */
    public $userIdToUnfollow;

    /**
     * @param $userId
     * @param $userIdToUnfollow
     */
    function __construct($userId, $userIdToUnfollow)
    {
        $this->userId = $userId;
        $this->userIdToUnfollow = $userIdToUnfollow;
    }

}