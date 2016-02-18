<?php
use Illuminate\Database\Eloquent\Collection;
use BibleExchange\Entities\User;

class AmenFetcher {
 
    /**
     * User we are fetching amens for
     * 
     * @var User
     */
    protected $user;
 
    /**
     * Number of amens to bring back
     * 
     * @var integer
     */
    protected $limit = 10;
 
    /**
     * Constructor
     * 
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
 
    /**
     * Fetch the amens
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function fetch()
    {
        $amensGroup = DB::table('amens')->select('amens.id', 
            DB::raw('max(amens.created_at) as created_at'), 
            DB::raw('count(distinct(amens.user_id)) as user_count'),
            DB::raw("case
                when count(DISTINCT(amens.user_id)) = 1 then users.first_name
                when count(DISTINCT(amens.user_id)) = 2 then GROUP_CONCAT(users.first_name SEPARATOR ' and ')
                when count(DISTINCT(amens.user_id)) > 2 then CONCAT(count(distinct(amens.user_id)), ' users' )
                end as sender_string"))
        ->join('users', 'users.id', '=', 'amens.user_id')
        ->whereRaw('user_id = ' . $this->user->id)
        ->groupBy('type', 'object_id');
 
        $amens = DB::table(DB::raw(sprintf('(%s) as ng', $amensGroup->toSql())))
            ->select('amens.*', 'ng.created_at')
            ->join('amens', 'amens.id', '=', 'ng.id')
            ->orderBy('ng.created_at', 'desc')
            ->limit($this->limit);
 
        return $this->toCollection($amens->get());
    }
 
    /**
     * Convert array to a Collection of amen Models
     * @param  array $amens
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function toCollection($amens)
    {
        if(empty($amens)) return [];
 
        $amenModels = [];
 
        foreach($amens as $amen)
        {
            $amenModels[] = new amen((array)$amen);
        }
 
        return new Collection($amenModels);
    }
 
    /**
     * Chainable setter for the limit property
     * 
     * @param  int $limit
     * @return amenFether
     */
    public function take($limit)
    {
        $this->limit = $limit;
 
        return $this;
    }
}