<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\NodeType;
use BibleExperience\Relay\Types\StepType;
use BibleExperience\Relay\Types\LessonType;
use BibleExperience\Relay\Types\NoteCacheType;
use BibleExperience\Relay\Types\OwnerType;
use BibleExperience\Relay\Types\SimpleBibleVerseType;

use BibleExperience\Note as NoteModel;

class UserNoteType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

	$defaultArgs = GraphQLGenerator::defaultArgs();
	$lessonsConnectionType = GraphQLGenerator::connectionType($typeResolver, LessonType::class);
	$stepsConnectionType = GraphQLGenerator::connectionType($typeResolver, StepType::class);

        return parent::__construct([
            'name' => 'UserNote',
            'description' => 'A users note.',
            'fields' => [
                'id' => Relay::globalIdField(),
                'title' => ['type' => Type::string()],
                'tags' => ['type' => Type::listOf(Type::string())],
            		'tags_string' => ['type' => Type::string()],
            		'body' => ['type' => Type::string()],
            		'type' => ['type' => Type::string()],
            		'bible_verse_id' => ['type' => Type::int()],
            		'created_at' => ['type' => Type::string()],
            		'updated_at' => ['type' => Type::string()],
            		'output' => ['type' => $typeResolver->get(NoteCacheType::class),'description' => 'Processed body of note'],
            		'verse' => ['type' => $typeResolver->get(SimpleBibleVerseType::class)],

                    'author' => ['type' => $typeResolver->get(OwnerType::class),'description' => 'author of note'],

		    	'lessons' => [
		            'type' => $typeResolver->get($lessonsConnectionType),
		            'description' => 'The lessons of this note.',
		            'args' => $defaultArgs,
		            'resolve' => function($root, $args, $resolveInfo){
		                return $this->paginatedConnection($root->lessons()->orderBy('order_by')->get(), $args);
		            }
		        ],
		    	'steps' => [
		            'type' => $typeResolver->get($stepsConnectionType),
		            'description' => 'The steps of this note.',
		            'args' => $defaultArgs,
		            'resolve' => function($root, $args, $resolveInfo){
		                return $this->paginatedConnection($root->steps()->orderBy('order_by')->get(), $args);
		            }
		        ],
            ],
           'interfaces' => [$typeResolver->get(NodeType::class)]
        ]);
    }

}
