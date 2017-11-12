<?php
namespace BibleExperience\Relay\Support\Traits;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use GraphQLRelay\Relay;
use GraphQL\Type\Definition\Type;

trait GlobalIdTrait
{
    /**
     * Create global id.
     *
     * @param  string $type
     * @param  string|integer $id
     * @return string
     */
    public static function encodeGlobalId($type, $id)
    {
        return Relay::toGlobalId($type, $id);
    }

    /**
     * Decode the global id.
     *
     * @param  string $id
     * @return array
     */
    public static function decodeGlobalId($globalId)
    {
	return Relay::fromGlobalId($globalId);
    }

    /**
     * Get the decoded GraphQL Type.
     *
     * @param  string $id
     * @return string
     */
    public static function decodeRelayType($id)
    {
        $result = Self::decodeGlobalId($id);
	       return $result['type'];
    }


    /**
     * Get the decoded id.
     *
     * @param  string $id
     * @return string
     */
    public static function decodeRelayId($id)
    {
        $result = Self::decodeGlobalId($id);
	return $result['id'];
    }

        public static function decodeCursor(array $args)
        {
            return isset($args['after']) ? Self::getCursorId($args['after']) : 0;
        }

        protected static function getCursorId($cursor)
        {
            return (int)Self::decodeRelayId($cursor);
        }

  public static function paginatedConnection($collection, $args)
  {

    $total = $collection->count();
    $orderBy = ["field"=>"id", "direction"=> "ASC"];

    if(isset($args['first'])){
       $first = $args['first'];
    }else{
        $first = 5;
    }
    
    if(isset($args['orderBy'])){
       $o = explode(":",$args['orderBy']);

        $orderBy['field'] = $o[0];

        if(isset($o[1])){
           $orderBy['direction'] = $o[1]; 
        }

        if($orderBy['direction'] === "ASC"){
            $collection = $collection->sortBy($orderBy["field"]);
        }else{
            $collection = $collection->sortByDesc($orderBy["field"]);
        }
        
    }

    $after = Self::decodeCursor($args);

    $after = $after+1;

    $currentPage = $first && $after ? floor(($first + $after) / $first) : 1;

    $data = new Paginator(
    $collection->slice($after)->take($first),
    $total,
    $first,
    $currentPage
    );

    $meta = ['sliceStart'=> $after, 'arrayLength'=>$data->total()];
    $args['after'] = $after;
    $args['last'] = $data->total();
    $totalCount = $data->total();

    return array_merge(
    [
    'totalCount' => $data->total(),
    'perPage' => $data->perPage(),
    'totalPagesCount' => $data->lastPage(),
    'currentPage' => $data->currentPage(),
    ],
    Relay::connectionFromArraySlice($data->items(), $args, $meta));
  }

  public static function paginationArgs(){
    return array_merge(
        Relay::connectionArgs(), 
        [
            'filter' => ['type' => Type::string()], 
            'id' => ['type' => Type::string()], 
            'orderBy' => ['type' => Type::string()] ,
            'page'=> ['type' => Type::int()],
            'perPage'=> ['type' => Type::int()]
        ]
        );

  }
  
}
