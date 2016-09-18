<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use Graphql;
    use BibleExperience\GraphQL\Field\StepField;
    use GraphQL\Type\Definition\ObjectType;

    class AttachmentClassType extends GraphQLType {
	
    protected $attributes = [
        'name' => 'AttachmentClass',
        'description' => 'The class of An attachment to a step.',
    ];

    public function fields()
    {
        return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the class'
		],
		'classname' => [
			'type' => Type::string(),
			'description' => ''
		]

	];
    }
   
}
