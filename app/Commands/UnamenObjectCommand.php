<?php namespace BibleExchange\Commands;

class UnamenObjectCommand {

    /**
     * @var
     */
    public $user;
    public $amenable_type;
    public $amenable_id;

    /**
     * @param string userId
     * @param string userIdToUnfollow
     */
    public function __construct($user, $amenable_type, $amenable_id)
    {
        $this->user = $user;
        $this->amenable_type = $amenable_type;
        $this->amenable_id = $amenable_id;
    }

}