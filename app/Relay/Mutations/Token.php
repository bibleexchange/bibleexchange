<?php namespace BibleExperience\Relay\Mutations;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\ErrorType AS Error;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\User as UserModel;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;

class Token {

  use GlobalIdTrait;

    public static function create(TypeResolver $typeResolver){

      $notesConnectionType = GraphQLGenerator::connectionType($typeResolver, NoteType::class);
      $defaultArgs = GraphQLGenerator::defaultArgs();
      $TokenClass = new Token;

      return Relay::mutationWithClientMutationId([
          'name' => 'CreateToken',
          'inputFields' => [
        'email' => [
            'type' => Type::nonNull(Type::string())
        ],
        'password' => [
            'type' =>  Type::nonNull(Type::string())
        ]
          ],
          'outputFields' => [

            'error' => [
                'type' => $typeResolver->get(Error::class),
                'resolve' => function ($payload) {
                    return $payload['error'];
                }
            ],
            'token' => [
                'type' => Type::string(),
                'resolve' => function ($payload) {
                    return $payload['token'];
                }
            ],
            'message' => [
                'type' => Type::string(),
                'resolve' => function ($payload) {

                    if($payload['error'] !== null){
                      return $payload['error']->message;
                    }else{
                      return null;
                    }


                }
            ],
            'code' => [
                'type' => Type::string(),
                'resolve' => function ($payload) {

                    if($payload['error'] !== null){
                      return $payload['error']->code;
                    }else{
                      return null;
                    }


                }
            ],
            'user' => [
                'type' => $typeResolver->get(UserType::class),
                'resolve' => function ($payload) {

                    if($payload['user'] !== null){
                      return $payload['user'];
                    }else{
                      return null;
                    }


                }
            ],
           'myNotes' => [
                  'type' => $typeResolver->get($notesConnectionType),
                  'description' => 'Current Users Notes.',
                  'args' => $defaultArgs,
                  'resolve' => function($root, $args, $resolveInfo){
                          return $TokenClass->paginatedConnection($payload['myNotes'], $args);
                      },
              ],

          ],
          'mutateAndGetPayload' => function ($input) {
            $newAuth = UserModel::createToken($input['email'], $input['password']);
              return [
                  'error' => $newAuth['error'],
                  'token' => $newAuth['token'],
                  'user' => $newAuth['user'],
                  'myNotes' => $newAuth['myNotes']
              ];
          }
      ]);
    }

}
