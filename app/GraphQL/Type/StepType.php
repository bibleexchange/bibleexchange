<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Graphql;
    use BibleExperience\GraphQL\Field\StepField;
    use GraphQL\Type\Definition\ObjectType;
    use BibleExperience\GraphQL\Support\Definition\RelayType;
    use BibleExperience\Step;
    
class StepType extends RelayType {


        protected $attributes = [
          'name' => 'step',
          'description' => 'A step.',
        ];

    public function resolveById($id)
    {
        return Step::find($id);
    }


        public function relayFields(){
           return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the step'
		],
		'cached' => [
			'type' => Type::string(),
			'description' => ''
		],
		'html' => [
			'type' => Type::string(),
			'description' => 'Processed body of step'
		],
		'url' => [
			'type' => Type::string(),
			'description' => ''
		],
		'course_id' => [
			'type' => Type::int(),
			'description' => 'errors'
		],
		'order_by' => [
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
		'nextStep' => [
			'type' => Graphql::type('step'),
			'description' => ''
		],
		'previousStep' => [
			'type' => Graphql::type('step'),
			'description' => ''
		],
		'attachments' => [
			'type' => Type::listOf(GraphQL::type('attachment')),
			'description' => ''
		],

	];
    }
   
}
