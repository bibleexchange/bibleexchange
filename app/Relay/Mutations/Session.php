<?php namespace BibleExperience\Relay\Mutations;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\ErrorType AS Error;
use BibleExperience\Relay\Types\ViewerType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\User as UserModel;
use BibleExperience\Relay\Support\GraphQLGenerator;
use BibleExperience\Relay\Support\Traits\GlobalIdTrait;
use BibleExperience\Viewer;
use stdClass;

class Session {

    public static function create(TypeResolver $typeResolver){

      $defaultArgs = GraphQLGenerator::defaultArgs();

      return Relay::mutationWithClientMutationId([
          'name' => 'CreateSession',
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
            'viewer' => [
                'type' => $typeResolver->get(ViewerType::class),
                'resolve' => function ($payload) {

                    if($payload['viewer'] !== null){
                      return $payload['viewer'];
                    }else{
                      return null;
                    }


                }
            ]

          ],
          'mutateAndGetPayload' => function ($input) {
            $newAuth = UserModel::createToken($input['email'], $input['password']);

              return [
                  'error' => $newAuth->error,
                  'token' => $newAuth->token,
                  'viewer' => new Viewer($newAuth)
              ];
          }
      ]);
    }


    public static function delete(TypeResolver $typeResolver){

      return Relay::mutationWithClientMutationId([
          'name' => 'DeleteSession',
          'inputFields' => [
            'token' => [
                'type' => Type::nonNull(Type::string())
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
            
            'viewer' => [
                'type' => $typeResolver->get(ViewerType::class),
                'resolve' => function ($payload) {
                      return $payload['viewer'];
                }
            ]

          ],
          'mutateAndGetPayload' => function ($input) {
            
            $auth = UserModel::failLogin();

              return [
                  'error' => $auth->error,
                  'token' => $auth->token,
                  'viewer' => new Viewer($auth)
              ];
          }
      ]);
    }


}
