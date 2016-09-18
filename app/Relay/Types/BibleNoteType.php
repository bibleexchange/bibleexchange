<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Types\NodeType as Node;
use BibleExperience\Relay\Types\UserType as User;
use BibleExperience\Relay\Types\NotePropertyType as NoteProperty;

use BibleExperience\Note as BibleNoteModel;

class BibleNoteType extends ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {
        return parent::__construct([
            'name' => 'BibleNote',
            'description' => 'A verse of the Holy Bible',
            'fields' => [
          	'id' => Relay::globalIdField(),
            'body' => [
                    'type' => Type::string(),
                    'description' => '',
            ],
            'author' => [
                    'type' => $typeResolver->get(User::class),
                    'description' => '',
            ],
            'properties' => [
                    'type' => $typeResolver->get(NoteProperty::class),
                    'description' => '',
            ],
            ],
           'interfaces' => [$typeResolver->get(Node::class)]]);
    }

       public static function modelFind($id,  $typeClass){
        	$model = BibleNoteModel::with('author')->find($id);
        	$model->relayType =  $typeClass;
        	return $model;
       }

}
