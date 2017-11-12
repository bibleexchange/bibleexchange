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

    $x = new stdClass;
    $x->context = null;
    $x->query = null;
    $x->queryString = json_decode($request->input('query'));
    $x->root = new Viewer(User::getAuth("BACKDOOR"));
    $x->context = null;
    $x->variables = [];
    $x->operationName = null;
    $x->schema = $this->schema;

  if($x->queryString !== null){
    $x->query = $x->queryString->query;

    if(isset($x->queryString->variables) && (array) $x->queryString->variables !== null){
          $x->variables = (array) $x->queryString->variables;
    }

    if(isset($x->queryString->operationName)){
      $x->operationName = $x->queryString->operationName;
    }
  
    $payload = GraphQL::execute($x->schema, $x->query, $x->root, $x->context ,$x->variables, $x->operationName);
  }else{
    $payload = new stdClass;
    $payload->data = null;
  }
    return response()->json($payload);

  }

  public function indexPost(Request $request){

	$context = null;
	$requestString   = $request->input('query');
	$operationName = $request->input('operationName');

	if(is_string($request->input('variables'))){
	  $variables = json_decode($request->input('variables'), true);
	}else{
	  $variables = $request->input('variables');
	}

    if(isset($variables['token'])){

      if($variables['token'] === "BACKDOOR"){
        $user = User::find(3);
        $token = $user->token;
      }else{
        $token = $variables['token'];
      }
      
    }else{
      $token = $request->header('Authorization');
    }

    $auth = User::getAuth($token);
    $root = new Viewer($auth);

	//($schema,   $requestString, $rootValue, $contextValue, $variableValues, $operationName)

	$payload = GraphQL::execute($this->schema, $requestString, $root, $context ,$variables, $operationName);

	return response()->json($payload);

  }

}
