<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Graphql;
    use BibleExperience\GraphQL\Field\StepField;
    use GraphQL\Type\Definition\ObjectType;
    use BibleExperience\GraphQL\Support\Definition\RelayType;
    use BibleExperience\BibleBook;
    use Relay;
    
class BibleBookType extends RelayType {

    protected $attributes = [
        'name' => 'BibleBook',
        'description' => 'A Bible Book is a list of chapters.',
    ];

    public function resolveById($id)
    {
        return BibleBook::find($id);
    }


        public function relayFields()
	{
        return [
		'id' => [
			'type' => Type::nonNull(Type::string()),
			'description' => 'The id of the module'
		],
		'n' => [
			'type' => Type::string(),
			'description' => ''
		],
		't' => [
			'type' => Type::int(),
			'description' => ''
		],
		'g' => [
			'type' => Type::int(),
			'description' => ''
		],
		'chapters' =>  [
			'type' => Type::listOf(GraphQL::type('bibleChapter')),
			'description' => ''
		],
		'chapterCount' => [
			'type' => Type::int(),
			'description' => ''
		],
	];
    }
 
}
