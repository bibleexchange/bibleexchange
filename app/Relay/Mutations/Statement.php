<?php namespace BibleExperience\Relay\Mutations;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use BibleExperience\Relay\Support\TypeResolver;
use BibleExperience\Relay\Support\GraphQLGenerator;
use GraphQLRelay\Relay;
use BibleExperience\Relay\Types\ErrorType;
use BibleExperience\Relay\Types\UserType;
use BibleExperience\Relay\Types\NoteType;
use BibleExperience\Relay\Types\TrackType;

use BibleExperience\User as UserModel;
use BibleExperience\Statement as StatementModel;
use BibleExperience\Track as TrackModel;

class Statement {

    public static function create(TypeResolver $typeResolver){

      return Relay::mutationWithClientMutationId([
    	    'name' => 'CreateStatement',
    	    'inputFields' => [
          		'token' => [
          		    'type' => Type::nonNull(Type::string())
          		],
          		'activity_id' => [
          		    'type' =>  Type::nonNull(Type::string())
          		],
              'verb' => [
                  'type' =>  Type::nonNull(Type::string())
              ],
              'track_id' => [
                  'type' =>  Type::nonNull(Type::string())
              ]
          	    ],
          'outputFields' => [
          		'error' => [
          		    'type' => Type::string(),
          		    'resolve' => function ($payload) {
          		        return $payload['error'];
          		    }
          		],
          		'code' => [
          		    'type' => Type::string(),
          		    'resolve' => function ($payload) {
          		        return $payload['code'];
          		    }
          		],
          		'track' => [
          		    'type' => $typeResolver->get(TrackType::class),
          		    'resolve' => function ($payload) {
          		        return $payload['track'];
          		    }
          		]
          ],
          'mutateAndGetPayload' => function ($input) {
          		
            $user = UserModel::getAuth($input['token']);
            $userCan = $user->user->can('CREATE_STATEMENT', $input);

            if($userCan->can){
                $statement = new StatementModel;
                $statement->user_id = $user->user->id;
                $statement->track_id = GraphQLGenerator::decodeId($input['track_id']);
                $statement->activity_id = GraphQLGenerator::decodeId($input['activity_id']);
                $statement->verb = $input['verb'];
                $statement->save();

                $new['track'] = $statement->track;
                $new['error'] = "";
                $new['code'] = 200;

            }else{
                $new['error'] = "Statement failed to save for some unknown reason.";
                $new['code'] = 500;
                $new['track'] = new TrackModel;
            }

          		return $new;
          	    }
          	]);

    }

}
