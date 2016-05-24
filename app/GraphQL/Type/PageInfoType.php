<?php namespace BibleExchange\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use BibleExchange\GraphQL\Support\Type as GraphQLType;
use GraphQL;
use BibleExchange\Entities\PageInfo;

class PageInfoType extends GraphQLType {

	protected $attributes = [
		'name' => 'Pageinfo',
		'description' => 'page info'
	];

	public function fields()
	{
		return [
			'hasPreviousPage' => [
				'type' => Type::boolean(),
				'description' => ''
			],
			'hasNextPage' => [
				'type' => Type::boolean(),
				'description' => ''
			],
			'numberOfPages' => [
				'type' => Type::int(),
				'description' => ''
			],
			'perPage' => [
				'type' => Type::int(),
				'description' => ''
			],
			'currentPage' => [
				'type' => Type::int(),
				'description' => ''
			]
		];
	}

}