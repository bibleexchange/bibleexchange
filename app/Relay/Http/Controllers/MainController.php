<?php namespace BibleExperience\Relay\Http\Controllers;

use BibleExperience\Relay\Schema\BibleExchangeSchema;
use BibleExperience\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use BibleExperience\User;
use BibleExperience\Viewer;

use GraphQL\GraphQL;

function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}

class MainController extends Controller
{

  public function __construct(){
	$this->schema = BibleExchangeSchema::build();

	$this->queries = $this->getQueries();
  }

  public function index(Request $request){

	$queryString   = $this->test($request->input('query'));
	$params = $request->input('params');

	//Schema $schema, $requestString, $rootValue = null, $variableValues = null, $operationName = null
	$payload = GraphQL::execute($this->schema, $queryString, null, $params);
echo "<div style='float:left;'>";
echo "<h2>#" . $request->input('query') . "</h2>";
print_r2($queryString);
echo "</div><div style='float:left'>";
print_r2(json_encode($payload, JSON_PRETTY_PRINT));
echo "</div><div style='display:block; clear:both'><hr />";
	print_r2($this->queries);
echo "</div>";

  }

  public function indexPost(Request $request){
	$root = new Viewer();
	$context = null;
	$requestString   = $request->input('query');
	$operationName = $request->input('operationName');

	if(is_string($request->input('variables'))){
	  $variables = json_decode($request->input('variables'), true);
	}else{
	  $variables = $request->input('variables');
	}

	//($schema,   $requestString, $rootValue, $contextValue, $variableValues, $operationName)
	$payload = GraphQL::execute($this->schema, $requestString, $root, $context ,$variables, $operationName);

	return response()->json($payload);

  }

  public function test($index){
  	return $this->queries[$index];
  }

public function getQueries(){

return [
	'{
  __schema {
    queryType {
      fields {
        name
        type {
          name
          kind
        }
        args {
          name
          type {
            kind
            ofType {
              name
              kind
            }
          }
        }
      }
    }
  }
}',
	'{ node (id:"QmlibGVDaGFwdGVyOjE"){
	    id
	    ... on BibleChapter {
	    id
      order_by
      verseCount
	    }
	  }
	}',
	'{ node(id: "QmlibGVFeHBlcmllbmNlXFJlbGF5XFR5cGVzXEJpYmxlVHlwZTox") {
	    id
	    ... on bible {
	      version
	      abbreviation
	      books(first:1, after:"YXJyYXljb25uZWN0aW9uOjI") {
	       edges {
		       cursor
		       node {
		        id
		        n
            chapterCount
		       }
		      }
	       pageInfo { hasNextPage, hasPreviousPage }
        }
	    }
	  }
	}',
  'query ViewerQuery {
viewer {
  bibleVerse(id:"01001001"){
    id
    reference
    notes(first:2, after:"YXJyYXljb25uZWN0aW9uOjE"){
      edges {
        cursor
        node {
          id
          body
          author {
            name
          }
        }
      }
    }
  }

  }
}',
  'query ViewerQuery {
viewer {
  library(find:"2"){
          id
          title
          courses(first:20){
            edges{
              cursor
              node{
                id
                title
                lessons (first:20) {
                  edges {
                    cursor
                    node{
                      id
                      order_by
                      steps(first:20){
                        edges{
                          cursor
                          node{
                            uuid
                            output
                          }
                        }
                      }
                    }

              }
            }
          }
        }
      }

  }
}
}',
	  'query ViewerQuery {
viewer {
user(token:"google-oauth2|111613418596493677798") {
      name
      email
      authenticated
      navHistory{
        edges{
          cursor
          node{
            id
            url
            title
          }
        }
      }
    }
    bible {
      abbreviation
      version
      books(first:66){
        edges {
          cursor
          node {
            title
            chapterCount
          }
        }
      }
    }
    bibleChapter(id:"1"){
            verses {
              edges {
                cursor
                node {
                  body
                }
              }
            }
          }
    bibleVerse(id:"01001001"){
      id
      reference
      }

    }
  }',
 	  'query IntrospectionQuery {
    __schema {
      queryType { name }
      mutationType { name }
      subscriptionType { name }
      types {
        ...FullType
      }
      directives {
        name

        locations
        args {
          ...InputValue
        }
      }
    }
  }

  fragment FullType on __Type {
    kind
    name

    fields(includeDeprecated: true) {
      name

      args {
        ...InputValue
      }
      type {
        ...TypeRef
      }
      isDeprecated
      deprecationReason
    }
    inputFields {
      ...InputValue
    }
    interfaces {
      ...TypeRef
    }
    enumValues(includeDeprecated: true) {
      name

      isDeprecated
      deprecationReason
    }
    possibleTypes {
      ...TypeRef
    }
  }

  fragment InputValue on __InputValue {
    name

    type { ...TypeRef }
    defaultValue
  }

  fragment TypeRef on __Type {
    kind
    name
    ofType {
      kind
      name
      ofType {
        kind
        name
        ofType {
          kind
          name
        }
      }
    }
  }',
        'query FetchVerseWithNotesQuery {
          bibleVerse(id: "01001001") {
            reference
            t
            notesCount
            notes (first:1){
              edges {
                cursor
                node {
                  body
                }
              }
            }
          }
        }',
        'query FetchVerseQuery {
          bibleVerse(id: "01001004") {
            reference
            t
          }
        }
        ',
       '
       query BibleChapter {
         bibleChapter(id: "1") {
           id
           order_by
           verseCount
           reference
           verses(first:1) {
            edges {
              cursor
              node {
               v
               book {n}
               chapter{order_by}
               notes(first:10){edges{cursor node {body}}}
              }
             }
            pageInfo { hasNextPage, hasPreviousPage }
           }
         }
       }
        ','
        query BibleChapter {
          bibleChapter(id: "QmlibGVDaGFwdGVyOjI") {
            id
            order_by
            verseCount
            reference
          }
        }
        ','
        query BibleChapter {
          bibleChapter(reference: "Genesis 2") {
            id
            order_by
            verseCount
            reference
          }
        }
        ','
        query ViewerQuery {
          course(id: "1") {
	    title
          }
        }
        ',
	'query Viewer {
        course(id:"1"){

          identifier
          currentStep( orderBy:"1") {
            id
            html
            order_by
            course_id
            nextStep {order_by}
            previousStep {order_by}
          }
        }
        bible(version:kjv){
          id
        }
        bibleChapter(reference:$reference){
          id
        }
      }','
        query FetchLukeAndLeiaAliased {
          luke: human(id: "1000") {
            name
          }
          leia: human(id: "1003") {
            name
          }
        }
        ','
        query DuplicateFields {
          luke: human(id: "1000") {
            name
            homePlanet
          }
          leia: human(id: "1003") {
            name
            homePlanet
          }
        }
        ','
        query UseFragment {
          luke: human(id: "1000") {
            ...HumanFragment
          }
          leia: human(id: "1003") {
            ...HumanFragment
          }
        }

        fragment HumanFragment on Human {
          name
          homePlanet
        }
        ','
        query CheckTypeOfR2 {
          hero {
            __typename
            name
          }
        }
        ','
        query CheckTypeOfKJV {
          bible(version: kjv) {
            __typename
            version
	           books {
	              chapterCount
            }
          }
        }
        ','
        query BibleFetchQuery {
          node(id: 1) {
            id
            ... on bible {
              version
              abbreviation
            }
          }
        }
        '
	];

}

}


