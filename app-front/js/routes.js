// routes.js
import React from 'react'
import { Route, IndexRoute } from 'react-router';

// Store
import BibleChapterStore from './stores/BibleChapterStore';

// Main component
import App from './components/App';
 
// Pages
import Bible from './components/Pages/Bible';
import Dashboard from './components/Pages/Dashboard';
import Default from './components/Pages/Default';
import ListEditor from './components/Pages/ListEditor';
import Login from './components/Pages/Login';
import NoMatch from './components/Pages/NoMatch';
import Search from './components/Pages/Search';
import Signup from './components/Pages/Signup';
import Study from './components/Pages/DirectedStudy';

import ListSectionEditor from './components/Partials/List/ListSectionEditor';

export default (
	<Route path="/" component={App}>
		<IndexRoute component={Dashboard}></IndexRoute>
		<Route path="about" component={Default}/>
		<Route path="contact" component={Default}/>
		<Route path="login" component={Login} ></Route>
		<Route name="signup" path="/signup" component={Signup}></Route>
		<Route path="study" component={Study}></Route>
		<Route path="search/:term(/:page)" component={Search} ></Route>				
		<Route path="bible" component={Bible} >
			<Route path=":book/:chapter" component={Bible} ></Route>
			<Route path=":book/:chapter/:verse" component={Bible}></Route>
			<Route path="*" component={NoMatch}/>
		</Route>
		<Route path="lists/:id" component={ListEditor}>
			<Route path=":section" component={ListSectionEditor}></Route>
		</Route>
		
		<Route path="*" component={NoMatch}/>
	</Route>
);