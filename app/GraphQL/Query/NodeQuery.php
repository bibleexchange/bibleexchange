<?php namespace BibleExperience\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use BibleExperience\GraphQL\Support\Definition\GraphQLQuery;
use BibleExperience\GraphQL\Traits\GlobalIdTrait;

class NodeQuery extends GraphQLQuery
{
    use GlobalIdTrait;

    /**
     * Associated GraphQL Type.
     *
     * @return mixed
     */
    public function type()
    {
        return GraphQL::type('node');
    }

    /**
     * Arguments available on node query.
     *
     * @return array
     */
    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id())
            ]
        ];
    }

    /**
     * Resolve query.
     *
     * @param  string $root
     * @param  array $args
     * @return Illuminate\Database\Eloquent\Model|array
     */
    public function resolve($root, array $args, ResolveInfo $info)
    {
        // Here, we decode the base64 id and get the id of the type
        // as well as the type's name.
        list($typeClass, $id) = $this->decodeGlobalId($args['id']);

        foreach (config('relay.schema.types') as $type => $class) {
            if ($typeClass == $class) {
                $objectType = app($typeClass);

                $model = $objectType->resolveById($id);

                if (is_array($model)) {
                    $model['graphqlType'] = $type;
                } elseif (is_object($model)) {
                    $model->graphqlType = $type;
                }

                return $model;
            }
        }

        return null;
    }
}
