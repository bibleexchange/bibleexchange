<?php namespace BibleExperience\GraphQL\Mutation;

    use GraphQL;
    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Mutation;    
    use BibleExperience\Course;
    use GraphQL\Type\Definition\InputObjectType;

    class UpdateCourseMutation extends Mutation {

        protected $attributes = [
            'name' => 'UpdateCourse'
        ];

        public function type()
        {
            return GraphQL::type('course');
        }

        public function args()
        {
            $args =  [
            'id' => [
		'name' => 'id',
                'type' => Type::nonNull(Type::string()),
                'rules' => ['required']
            ],
            'title' => [
		'name' => 'title',
                'type' => Type::string(),
                'rules' => ['string']
            ],
            'description' => [
                'type' => Type::string(),
                'rules' => ['string']
            ],
            'user_id' => [
                'type' => Type::int(),
                'rules' => ['numeric']
            ],
            'public' => [
                'type' => Type::string(),
                'rules' => ['boolean']
            ],
            'image' => [
                'type' => Type::string(),
                'rules' => ['url']
            ],
            'bible_verse_id' => [
                'type' => Type::int(),
                'rules' => ['numeric']
            ]
         ];

	$inputType = new InputObjectType([
            'name' => 'UpdateCourseInput',
            'fields' => array_merge($args, [
                'clientMutationId' => [
                    'type' => Type::nonNull(Type::string())
                ]
            ])
        ]);

        return [
            'input' => [
                'type' => Type::nonNull($inputType)
            ]
        ];

        }

        public function resolve($root, $args)
        {
	  $input = $args['input'];
     	  $course = Course::find($input['id']);

          unset($input['id']);
          unset($input['clientMutationId']);

	foreach($input AS $key => $value){
	  $course->$key = $value;
	}

        $course->save();

       return $course;

        }

    }

/*

mutation UpdateCourse {
  updateCourse(input: {id: "58",title:"See you over there.", clientMutationId:""}) {
    title
    stepsCount
  }
}


*/
