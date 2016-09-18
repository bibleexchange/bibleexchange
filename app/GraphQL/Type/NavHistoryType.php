<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Graphql;
    use BibleExperience\GraphQL\Field\StepField;
    use GraphQL\Type\Definition\ObjectType;
    use BibleExperience\GraphQL\Support\Definition\RelayType;
    use Auth;
    use Relay;
    
class NavHistoryType extends RelayType {

    protected $attributes = [
	'name' => 'NavHistory',
	'description' => 'Users Navigation History'
    ];
   

    public function resolveById($id)
    {
        return Auth::user()->navHistory[$id];
    }


    public function relayFields()
    {
        return [
		'dataID' => [
			'type' => Type::nonNull(Type::int()),
			'description' => 'The id of the nav'
		],
		'url' => [
			'type' => Type::string(),
			'description' => 'The text of the bible verse'
		],
		'title' => [
			'type' => Type::string(),
			'description' => 'The text of the bible verse'
		]
	];
    }

}
