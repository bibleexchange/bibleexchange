# Bible Exchange Architecture Explanations and Examples

## Libraries Used

### PHP
1. [Laravel]()
2. [Webonyx GraphQL-PHP]()
3. [Graham/Campbell Markdown]()
4. [Evernote Cloud PHP SDK]()

### Javascript

#### Production

1. [React]()
2. [React DOM]()
3. [React Router]()
4. [Flux]()
5. [Axios]()

#### Develepment
1. [Gulp]()
2. [Browserify]()
3. [Babelify]()
4. [Jquery]()

## Language Functions

### Laravel Framework: Backend Graphql Endpoint/API & Server Side Rendering
### React Framework: Frontend UI and ASSYNC ("Axios") requests to PHP/Laravel GraphQL API.

## FLUX Architecture as Implemented in the Bible Exchange Application

CREDIT: Original inspiration from [Facebook](https://facebook.github.io/flux/) and [Tyler Mcginnis](http://tylermcginnis.com/reactjs-tutorial-pt-3-architecting-react-js-apps-with-flux/).

	---------------------------------		---------------------------------		---------------------------------
	|		**Views/Components**	|		|		 **ACTIONS**			|		|		 **DISPATCHER**			|
	|	-typical React components	|  -->	|	-A component 'function' that|  -->	|	-							|
	|	-Gets initial state from 	|		|	invokes an Action Method on	|		|								|
	|			stores				|		|	the Dispatcher				|		|	-An action invokes a method	|
	|	-Sets up a listener so when	|		|								|		|	on the dispatcher which		|
	|		store emits a change	|		|	/actions					|		|	emits an event along with	|
	| event component will re-fetch	|		|								|		|	any data that needs to go to|
	|	    data from stores and	|		|	- simply prepares events for|		|	the store.					|
	|	update its own state		|		|	the dispatcher				|		|								|
	|								|		|	- handles ASSYNC requests	|		|								|
	|	/components & /pages		|		|								|		|	/dispatcher.js				|
	|								|		|								|		|								|
	|								|		|								|		|	- Currently using Facebook's|
	|	- "/pages" act as a cont-	|		|								|		|	vanilla dispatcher			|
	|	roller for all child compo-	|		|								|		|								|
	|	nents. (Maintains its state |		|								|		|								|
	|	and passes data as props to	|		|								|		|								|
	|	its children components.)	|		|								|		|								|
	---------------------------------		---------------------------------		---------------------------------
																								|
				^																				|
                |               		---------------------------------                       |        		
				|						|			**STORES**			|						|
				|						|	- The store listens for		|						|
				|						|	certain events and when it	|						|
				|						|	hears an event (from Dis-	|						|
				|						|	patcher) its listening for	|						|
				----------------------	|	then it modifies its own	|	<-------------------
										|	data and emits a "change"	|
										|	event.						|
										|	- components listen for an 	|
										|	emitted "change" and then 	|
										|	updates itself.				|
										|								|
										|	/stores						|
										|								|
                                		---------------------------------  
										
## USER ACTIONS:

### Manually Edit and Sends Browser URL/Search Bar


#### IF Pattern Matches: "/bible"

#### IF Pattern Matches: "/bible/genesis"

#### IF Pattern Matches: "/bible/genesis/1"

#### IF Pattern Matches: "/bible/genesis/1/1"

#### IF Pattern Matches: "/bible/gynes*" {not a valid scripture reference}

> app.js -> react-router.js [matches to path: bible(/:book)(/:chapter)(/:verse)]-> Bible.js [a Page or ViewController]-> Bible.constructor [loads state from 1) chapter, 2) search and 3) verse stores.] ->Bible.componentWillMount [console logs "Bible will mount"]  -> 