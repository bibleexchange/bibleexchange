<?php namespace BibleExperience\Relay\Support\Definition;

use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use GraphQL\Type\Definition\ObjectType;
use BibleExperience\Relay\Models\StarWarsData;

use BibleExperience\Relay\Support\TypeResolver;

abstract class RelayType extends ObjectType
{
    use GlobalIdTrait;
    

/**
     * List of fields with global identifier.
     *
     * @return array
     */
    public function fields()
    {
        return array_merge($this->relayFields(), $this->getConnections(), [
            'id' => [
                'type'        => Type::nonNull(Type::id()),
                'description' => 'ID of type.',
                'resolve'     => function ($obj) {
                    return $this->encodeGlobalId(get_called_class(), $this->getIdentifier($obj));
                },
            ],
        ]);
    }
    /**
     * Available connections for type.
     *
     * @return array
     */
    protected function connections()
    {
        return [];
    }
    /**
     * Generate Relay compliant edges.
     *
     * @return array
     */
    public function getConnections()
    {
        return collect($this->connections())->transform(function ($edge, $name) {
            if (!isset($edge['resolve'])) {
                $edge['resolve'] = function ($root, array $args, ResolveInfo $info) use ($name) {
                    return GraphQL::resolveConnection($root, $args, $info, $name);
                };
            }
            $edge['args'] = RelayConnectionType::connectionArgs();
            return $edge;
        })->toArray();
    }
    /**
     * Get the identifier of the type.
     *
     * @param  mixed $obj
     * @return mixed
     */
    public function getIdentifier($obj)
    {
        return $obj->id;
    }
    /**
     * List of available interfaces.
     *
     * @return array
     */
    public function interfaces()
    {
        return [GraphQL::type('node')];
    }
    /**
     * Get list of available fields for type.
     *
     * @return array
     */
    abstract protected function relayFields();
    /**
     * Fetch type data by id.
     *
     * @param string $id
     *
     * @return mixed
     */
    abstract public function resolveById($id);

    /**
     * Get the attributes of the type.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = array_merge(
            $this->attributes, [
                'fields' =>  $this->getFields(),
            ]);
        if(sizeof($this->interfaces())) {
            $attributes['interfaces'] = $this->interfaces();
        }
        return $attributes;
    }
    /**
     * The resolver for a specific field.
     *
     * @param $name
     * @param $field
     * @return \Closure|null
     */
    protected function getFieldResolver($name, $field)
    {
        if(isset($field['resolve'])) {
            return $field['resolve'];
        } else if(method_exists($this, 'resolve'.studly_case($name).'Field')) {
            $resolver = array($this, 'resolve'.studly_case($name).'Field');
            return function() use ($resolver) {
                return call_user_func_array($resolver, func_get_args());
            };
        }
        return null;
    }
    /**
     * Get the fields of the type.
     *
     * @return array
     */
    public function getFields()
    {
        $collection = new Collection($this->fields());
        return $collection->transform(function ($field, $name) {
            if(is_string($field)) {
                $field = app($field);
                $field->name = $name;
                return $field->toArray();
            } else {
                $resolver = $this->getFieldResolver($name, $field);
                if ($resolver) {
                    $field['resolve'] = $resolver;
                }
                return $field;
            }
        })->toArray();
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }
    /**
     * Convert this class to its ObjectType.
     *
     * @return ObjectType
     */
    public function toType()
    {
        return new ObjectType($this->toArray());
    }
    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        $attributes = $this->getAttributes();
        return isset($attributes[$key]) ? $attributes[$key]:null;
    }
    /**
     * Dynamically check if an attribute is set.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->getAttributes()[$key]);
    }

}


