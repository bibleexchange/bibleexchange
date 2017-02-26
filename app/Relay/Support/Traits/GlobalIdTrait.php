<?php
namespace BibleExperience\Relay\Support\Traits;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use GraphQLRelay\Relay;

trait GlobalIdTrait
{
    /**
     * Create global id.
     *
     * @param  string $type
     * @param  string|integer $id
     * @return string
     */
    public function encodeGlobalId($type, $id)
    {
        return Relay::toGlobalId($type, $id);
    }

    /**
     * Decode the global id.
     *
     * @param  string $id
     * @return array
     */
    public function decodeGlobalId($globalId)
    {
	return Relay::fromGlobalId($globalId);
    }

    /**
     * Get the decoded GraphQL Type.
     *
     * @param  string $id
     * @return string
     */
    public function decodeRelayType($id)
    {
        $result = $this->decodeGlobalId($id);
	       return $result['type'];
    }


    /**
     * Get the decoded id.
     *
     * @param  string $id
     * @return string
     */
    public function decodeRelayId($id)
    {
        $result = $this->decodeGlobalId($id);
	return $result['id'];
    }

        public function decodeCursor(array $args)
        {
            return isset($args['after']) ? $this->getCursorId($args['after']) : 0;
        }

        protected function getCursorId($cursor)
        {
            return (int)$this->decodeRelayId($cursor);
        }

        protected function paginatedConnection($collection, $args)
        {

               $total = $collection->count();
               $first = $args['first'];
               $after = $this->decodeCursor($args);

	       if ($after !== 0){$after = $after+1;}

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
}
