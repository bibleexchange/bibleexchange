<?php namespace BibleExperience\Relay\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Relay\Support\GraphQLGenerator;

use BibleExperience\Relay\Types\ErrorType;

use BibleExperience\Note as NoteModel;

class AuthType extends ObjectType {

   public function __construct(TypeResolver $typeResolver)
      {
          return parent::__construct([
              'name' => 'Auth',
              'description' => 'Authentication information for user',
              'fields' => [
              		'error' => ['type' => $typeResolver->get(ErrorType::class)],
              		'auth' => ['type' => Type::boolean()],
                  'type' => ['type' => Type::string()]
              ],
             'interfaces' => []
          ]);
      }

  }
