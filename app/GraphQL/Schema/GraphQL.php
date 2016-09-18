<?php namespace BibleExperience\GraphQL\Schema;

use Closure;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Error;
use GraphQL\Schema;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InterfaceType;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

use BibleExperience\GraphQL\Support\ValidationError;
use BibleExperience\GraphQL\Support\Definition\RelayType;
use BibleExperience\GraphQL\Support\Definition\EloquentType;
use BibleExperience\GraphQL\Support\Definition\RelayConnectionType;
use BibleExperience\GraphQL\Support\ConnectionResolver;


use GraphQL AS GraphQLO;

class GraphQL
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Collection of registered queries.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $queries;

    /**
     * Collection of registered mutations.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $mutations;

    /**
     * Collection of type instances.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $typeInstances;

    /**
     * Collection of connection type instances.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $connectionInstances;

    /**
     * Collection of connection edge instances.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $edgeInstances;

    /**
     * Instance of connection resolver.
     *
     * @var ConnectionResolver
     */
    protected $connectionResolver;

    /**
     * Instance of cache store.
     *
     * @var \Nuwave\Relay\Support\Cache\FileStore
     */
    protected $cache;

    /**
     * Create a new instance of GraphQL.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        $this->app = $app;

        $this->types = collect(GraphQLO::getTypes());
        $this->queries = collect();
        $this->mutations = collect();
        $this->typeInstances = collect();
        $this->connectionInstances = collect();
        $this->edgeInstances = collect();
    }

    /**
     * Execute GraphQL query.
     *
     * @param  string $query
     * @param  array $variables
     * @param  mixed $rootValue
     * @return array
     */
    public function query($query, $variables = [], $rootValue = null)
    {
        $result = $this->queryAndReturnResult($query, $variables, $rootValue);

        if (!empty($result->errors)) {
            return [
                'data' => $result->data,
                'errors' => array_map([$this, 'formatError'], $result->errors)
            ];
        }

        return ['data' => $result->data];
    }

    /**
     * Execute GraphQL query.
     *
     * @param  string $query
     * @param  array $variables
     * @param  mixed $rootValue
     * @return array
     */
    public function queryAndReturnResult($query, $variables = [], $rootValue = null)
    {
        return GraphQLBase::executeAndReturnResult($this->schema(), $query, $rootValue, $variables);
    }

    /**
     * Generate GraphQL Schema.
     *
     * @return \GraphQL\Schema
     */
    public function schema()
    {
        $schema = config('relay.schema');

        $this->types->each(function ($type, $key) {
            $this->type($key);
        });

        $queries = $this->queries->merge(array_get($schema, 'queries', []));
        $mutations = $this->mutations->merge(array_get($schema, 'mutations', []));

        $queryTypes = $this->generateType($queries, ['name' => 'Query']);
        $mutationTypes = $this->generateType($mutations, ['name' => 'Mutation']);

        return new Schema($queryTypes, $mutationTypes);
    }

    /**
     * Generate type from collection of fields.
     *
     * @param  Collection $fields
     * @param  array     $options
     * @return \GraphQL\Type\Definition\ObjectType
     */
    public function generateType(Collection $fields, $options = [])
    {
        $typeFields = $fields->transform(function ($field) {
            if (is_string($field)) {
                return app($field)->toArray();
            }

            return $field;
        })->toArray();

        return new ObjectType(array_merge(['fields' => $typeFields], $options));
    }

    /**
     * Add mutation to collection.
     *
     * @param string $name
     * @param mixed $mutator
     */
    public function addMutation($name, $mutator)
    {
        $this->mutations->put($name, $mutator);
    }

    /**
     * Add query to collection.
     *
     * @param string $name
     * @param mixed $query
     */
    public function addQuery($name, $query)
    {
        $this->queries->put($name, $query);
    }

    /**
     * Add type to collection.
     *
     * @param mixed $class
     * @param string|null $name
     */
    public function addType($class, $name = null)
    {
        if (!$name) {
            $type = is_object($class) ? $class : app($class);
            $name = $type->name;
        }

        $this->types->put($name, $class);
    }

    /**
     * Get instance of type.
     *
     * @param  string $name
     * @param  boolean $fresh
     * @return mixed
     */
    public function type($name, $fresh = false)
    {
        $this->checkType($name);

        if (!$fresh && $this->typeInstances->has($name)) {
            return $this->typeInstances->get($name);
        }

        $type = $this->types->get($name);
        if (!is_object($type)) {
            $type = app($type);
        }

        $instance = $type instanceof Model ? (new EloquentType($type, $name))->toType() : $type->toType();

        $this->typeInstances->put($name, $instance);

        if ($type->interfaces) {
            InterfaceType::addImplementationToInterfaces($instance);
        }

        return $instance;
    }

    /**
     * Get if type is registered.
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasType($name)
    {
        return $this->typeInstances->has($name);
    }

    /**
     * Get registered type.
     *
     * @param  string $name
     * @return \GraphQL\Type\Definition\OutputType
     */
    public function getType($name)
    {
        return $this->typeInstances->get($name);
    }

    /**
     * Get instance of connection type.
     *
     * @param  string $name
     * @param  Closure|string|null $resolve
     * @param  boolean $fresh
     * @return mixed
     */
    public function connection($name, $resolve = null, $fresh = false)
    {
        $this->checkType($name);

        if ($resolve && !$resolve instanceof Closure) {
            $resolve = function ($root, array $args, ResolveInfo $info) use ($resolve) {
                return $this->resolveConnection($root, $args, $info, $resolve);
            };
        }

        if (!$fresh && $this->connectionInstances->has($name)) {
            $field = $this->connectionInstances->get($name);
            $field['resolve'] = $resolve;

            return $field;
        }

        $field = $this->connectionField($name, $resolve);

        $this->connectionInstances->put($name, $field);

        return $field;
    }

    /**
     * Get instance of edge type.
     *
     * @param  string $name
     * @return \GraphQL\Type\Definition\ObjectType|null
     */
    public function edge($name)
    {
        $this->checkType($name);

        return $this->edgeInstances->get($name);
    }

    /**
     * Format error for output.
     *
     * @param  Error  $e
     * @return array
     */
    public function formatError(Error $e)
    {
        $error = ['message' => $e->getMessage()];

        $locations = $e->getLocations();
        if (!empty($locations)) {
            $error['locations'] = array_map(function ($location) {
                return $location->toArray();
            }, $locations);
        }

        $previous = $e->getPrevious();
        if ($previous && $previous instanceof ValidationError) {
            $error['validation'] = $previous->getValidatorMessages();
        }

        return $error;
    }

    /**
     * Check if type is registered.
     *
     * @param  string $name
     * @return void
     */
    protected function checkType($name)
    {
        if (!$this->types->has($name)) {
            throw new \Exception("Type [{$name}] not found.");
        }
    }

    /**
     * Generate connection field.
     *
     * @param  string $name
     * @param  Closure|null $resolve
     * @return array
     */
    public function connectionField($name, $resolve = null)
    {
        $type = new RelayConnectionType();
        $connectionName = (!preg_match('/Connection$/', $name)) ? $name.'Connection' : $name;

        $type->setName(studly_case($connectionName));
        $type->setEdgeType($name);
        $instance = $type->toType();
        $this->addEdge($instance, $name);

        $field = [
            'args' => RelayConnectionType::connectionArgs(),
            'type' => $instance,
            'resolve' => $resolve
        ];

        if ($type->interfaces) {
            InterfaceType::addImplementationToInterfaces($instance);
        }

        return $field;
    }

    /**
     * Add edge instance.
     *
     * @param  ObjectType $type
     * @param  string     $name
     * @return void
     */
    public function addEdge(ObjectType $type, $name)
    {
        if ($edges = $type->getField('edges')) {
            $type = $edges->getType()->getWrappedType();

            $this->edgeInstances->put($name, $type);
        }
    }

    /**
     * Auto-resolve connection.
     *
     * @param  mixed $root
     * @param  array $args
     * @param  ResolveInfo $info
     * @param  string $name
     * @return mixed
     */
    public function resolveConnection($root, array $args, ResolveInfo $info, $name = '')
    {
        return $this->getConnectionResolver()->resolve($root, $args, $info, $name);
    }

    /**
     * Set instance of connection resolver.
     *
     * @param ConnectionResolver $resolver
     */
    public function setConnectionResolver(ConnectionResolver $resolver)
    {
        $this->connectionResolver = $resolver;
    }

    /**
     * Get instance of connection resolver.
     *
     * @return ConnectionResolver
     */
    public function getConnectionResolver()
    {
        return $this->connectionResolver ?: app(ConnectionResolver::class);
    }

    /**
     * Get instance of cache store.
     *
     * @return \Nuwave\Relay\Support\Cache\FileStore
     */
    public function cache()
    {
        return $this->cache ?: app(\Nuwave\Relay\Support\Cache\FileStore::class);
    }

    /**
     * Set instance of Cache store.
     *
     * @param \Nuwave\Relay\Support\Cache\FileStore
     */
    public function setCache(FileStore $cache)
    {
        $this->cache = $cache;
    }
}
