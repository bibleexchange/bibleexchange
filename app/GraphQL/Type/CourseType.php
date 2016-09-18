<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Graphql;
    use BibleExperience\GraphQL\Field\StepField;
    use GraphQL\Type\Definition\ObjectType;
    use BibleExperience\GraphQL\Support\Definition\RelayType;
    use BibleExperience\Course;
    use Relay;
    
class CourseType extends RelayType {

        protected $attributes = [
            'name' => 'Course',
            'description' => 'A course'
        ];

    public function resolveById($id)
    {
        return Course::find($id);
    }


        public function relayFields()
        {
            return [
		'identifier' => [
			'type' => Type::int(),
			'description' => ''
		],
		'bible_verse_id' => [
			'type' => Type::int(),
			'description' => ''
		],
		'title' => [
			'type' => Type::string(),
			'description' => ''
		],
		'description' => [
			'type' => Type::string(),
			'description' => ''
		],
		'image_id' => [
			'type' => Type::int(),
			'description' => 'T'
		],
		'user_id' => [
			'type' => Type::int(),
			'description' => 'errors'
		],
		'owner' => [
			'type' => GraphQL::type('user'),
			'description' => ''
		],
		'steps' =>  [
			'type' => Type::listOf(GraphQL::type('step')), //Relay::connection('step', 'steps'), /*
			'description' => ''
		],
		//'currentStep' => StepField::class,
		'stepsCount' => [
			'type' => Type::int(),
			'description' => ''
		],
		'created_at' => [
			'type' => Type::string(),
			'description' => ''
		],
		'updated_at' => [
			'type' => Type::string(),
			'description' => ''
		],
		'clientMutationId' =>[
			'type' => Type::string(),
			'description' => ''
		]
            ];


        }


        protected function resolveDataIdField($root, $args)
        {
            return $root->id;
        }

    }
