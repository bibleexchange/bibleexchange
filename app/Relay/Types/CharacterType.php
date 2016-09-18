<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Models\StarWarsData;

use BibleExperience\Relay\Support\TypeResolver;

use BibleExperience\Relay\Types\DroidType as Droid;
use BibleExperience\Relay\Types\HumanType as Human;
use BibleExperience\Relay\Types\EpisodeType as Episode;

class CharacterType extends InterfaceType {
  
 public function __construct(TypeResolver $typeResolver)
    {

        return parent::__construct([
            'name' => 'Character',
            'description' => 'A character in the Star Wars Trilogy',
            'fields' => [
                'id' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The id of the character.',
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The name of the character.'
                ],
                'friends' => [
                    'type' =>  function () use (&$typeResolver){
                        return Type::listOf($typeResolver->get(CharacterType::class));
                    },
                    'description' => 'The friends of the character, or an empty list if they have none.',
                ],
                'appearsIn' => [
                    'type' => Type::listOf($typeResolver->get(Episode::class)),
                    'description' => 'Which movies they appear in.'
                ]
            ],
            'resolveType' => function ($obj) use (&$typeResolver) {
                $humans = StarWarsData::humans();
                $droids = StarWarsData::droids();
                if (isset($humans[$obj['id']])) {
                    return $typeResolver->get(Human::class);
                }
                if (isset($droids[$obj['id']])) {
                    return $typeResolver->get(Droid::class);
                }
                return null;
            },
        ]);
    }

}

