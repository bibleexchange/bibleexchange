<?php namespace BibleExperience\Relay\Http\Controllers;

use BibleExperience\Relay\Schema\BibleExchangeSchema;
use BibleExperience\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

	$this->queries = [
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
	'{ node (id:"QmlibGVDaGFwdGVyOjI"){
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
            n
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
                  t
                }
              }
            }
          }
    bibleVerse(id:"01001001"){
      id
      reference
      notes(first:10, after:"opaqueCursor"){
        edges {
          cursor
          node {
            id
            body
            properties {
              tags
            }
          }
        }
      }
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
        query FetchLukeAliased {
          luke: human(id: "1000") {
            name
          }
        }
        ','
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

  public function index(Request $request){

	$queryString   = $this->test($request->input('query'));
	$params = $request->input('params');

	//Schema $schema, $requestString, $rootValue = null, $variableValues = null, $operationName = null
	$payload = GraphQL::execute($this->schema, $queryString, null, $params);

	header('Content-Type: application/json');
	echo json_encode($payload);

	print_r2($this->queries);


  }

  public function indexPost(Request $request){

	$queryString   = $request->input('query');
	$params = $request->input('params');

	//Schema $schema, $requestString, $rootValue = null, $variableValues = null, $operationName = null
	$payload = GraphQL::execute($this->schema, $queryString, null, $params);
  return response()->json($payload);

  }

  public function test($index){
  	return $this->queries[$index];
  }

}

/*
chapters(first:1) {
 edges {
   cursor
   node {
    id
   }
  }
 pageInfo { hasNextPage, hasPreviousPage }
}
*/
