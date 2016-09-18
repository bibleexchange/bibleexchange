<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Models\StarWarsData;

use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

use BibleExperience\Relay\Types\BibleType as Bible;
use BibleExperience\Relay\Types\DroidType as Droid;
use BibleExperience\Relay\Types\HumanType as Human;
use BibleExperience\Relay\Types\EpisodeType as Episode;

use BibleExperience\Bible AS BibleModel;

class NodeType extends InterfaceType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
      return parent::__construct([
          'name' => 'Node',
          'description' => 'An object with an ID',
          'fields' => [
              'id' => [
                  'type' => Type::nonNull(Type::id()),
                  'description' => 'The id of the object',
              ]
          ],
          'resolveType' => function($obj) use (&$typeResolver){
		return $typeResolver->get($obj->relayType);
          }
      ]);
    }
}
