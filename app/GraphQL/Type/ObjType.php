<?php namespace BibleExperience\GraphQL\Type;

    use GraphQL\Type\Definition\Type;
    use Folklore\GraphQL\Support\Type as GraphQLType;
    use BibleExperience\Step;
    use GraphQL;

use \BibleExperience\GraphQL\Type\BibleChapterType;
use \BibleExperience\GraphQL\Type\BibleVerseType;
use \BibleExperience\GraphQL\Type\NoteType;
//use \BibleExperience\GraphQL\Type\BibleListType;
//use \BibleExperience\GraphQL\Type\LinkType;
//use \BibleExperience\GraphQL\Type\TestType;
//use \BibleExperience\GraphQL\Type\TextType;

    class ObjType extends GraphQLType {

     protected $attributes = [
        'name' => 'Obj',
        'description' => 'A object of attachment of the application.',
    ];

        public function fields(){
	$array = (new NoteType)->fields();	
	$array = array_merge($array, (new BibleVerseType)->fields());
	$array = array_merge($array, (new BibleChapterType)->fields());
	//$array = array_merge($array, (new LinkType)->fields());
	//$array = array_merge($array, (new RecordingType)->fields());
	//$array = array_merge($array, (new TestType)->fields());
	//$array = array_merge($array, (new TextType)->fields());

        return $array;
    }


}
