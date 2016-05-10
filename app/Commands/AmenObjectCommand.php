<?php namespace BibleExchange\Commands;

class AmenObjectCommand {

    /**
     * @var
     */
    public $user;
    public $amenable_type;
    public $amenable_id;
    
    /**
     * @param $userId
     * @param $userIdToFollow
     */
    function __construct($user, $amenable_type, $amenable_id)
    {
        $this->user = $user;
        $this->amenable_type = $amenable_type;
        $this->amenable_id = $amenable_id;
    }

}