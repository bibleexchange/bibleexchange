<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use Graphql;

    class AttachmentType extends GraphQLType {

      protected $attributes = [
        'name' => 'Attachment',
        'description' => 'An attachment to a step.',
      ];

      public function fields()
      {
        return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the step'
		],
		'step_id' => [
			'type' => Type::int(),
			'description' => ''
		],
		'object_type_id' => [
			'type' => Type::int(),
			'description' => ''
		],
		'object_id' => [
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
		'obj' => [
			'type' => Graphql::type('obj'),
			'description' => ''
		],
		'description' => [
			'type' => Type::string(),
			'description' => ''
		],
		'type' => [
			'type' => Graphql::type('attachmentClass'),
			'description' => ''
		],

	];
    }
   
}
