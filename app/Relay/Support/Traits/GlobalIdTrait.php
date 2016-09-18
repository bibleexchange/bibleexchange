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
        return base64_encode($type . ':' . $id);
    }
    /**
     * Decode the global id.
     *
     * @param  string $id
     * @return array
     */
    public function decodeGlobalId($id)
    {
        return explode(":", base64_decode($id));
    }
    /**
     * Get the decoded id.
     *
     * @param  string $id
     * @return string
     */
    public function decodeRelayId($id)
    {
      if(strpos(':',$id)){
        list($type, $id) = $this->decodeGlobalId($id);
      }
        return $id;
    }
    /**
     * Get the decoded GraphQL Type.
     *
     * @param  string $id
     * @return string
     */
    public function decodeRelayType($id)
    {
        list($type, $id) = $this->decodeGlobalId($id);
        return $type;
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
          $after = null;

          if (isset($args['first'])) {
                             $total       = $collection->count();
                             $first       = $args['first'];
                             $after       = $this->decodeCursor($args);
                             $currentPage = $first && $after ? floor(($first + $after) / $first) : 1;

                             $data = new Paginator(
                                 $collection->slice($after)->take($first),
                                 $total,
                                 $first,
                                 $currentPage
                             );
                         }else {
                           $data = new Paginator(
                               $collection,
                               $collection->count(),
                               $collection->count()
                           );
                         }

               $meta = ['sliceStart'=> $after, 'arrayLength'=>$data->total()];
               $args['after'] = $after;
               $args['last'] = $data->total();

          return Relay::connectionFromArraySlice($data->items(), $args, $meta);
                      }
}