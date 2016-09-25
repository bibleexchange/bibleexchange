<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Models\StarWarsData;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\Definition\RelayType;

use BibleExperience\Relay\Types\BibleBookType as BibleBook;
use BibleExperience\Relay\Types\NodeType as Node;

use BibleExperience\Bible AS BibleModel;
use GraphQLRelay\Relay;

class BibleType extends  ObjectType {

use GlobalIdTrait;

 public function __construct(TypeResolver $typeResolver)
    {

	$bibleBooksConnection = Relay::connectionDefinitions(['nodeType' => $typeResolver->get(BibleBook::class)]);

        return parent::__construct([
            'name' => 'Bible',
            'description' => 'A version of the Holy Bible',
            'fields' => [
		'id' => Relay::globalIdField(),
		'abbreviation' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'language' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'version' => [
                    'type' => Type::string(),
                    'description' => 'The version of the Bible.',
                ],
                'info_text' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'info_url' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'publisher' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'copyright' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
                'copyright_info' => [
                    'type' => Type::string(),
                    'description' => '',
                ],
		'books' => [
                    'type' =>  $bibleBooksConnection['connectionType'],
                    'description' => 'The books of the Bible.',
            		    'args' => Relay::connectionArgs(),
            		    'resolve' => function($bible, $args, $resolveInfo){
                        return $this->paginatedConnection($bible->books, $args);
            			}
                ]
		          ],
            'interfaces' => [$typeResolver->get(Node::class)]

        ]);
    }

   public static function modelFind($id,  $typeClass){
    	$model = BibleModel::find($id);
    	$model->relayType =  $typeClass;
    	return $model;
   }

 }
