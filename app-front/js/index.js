import React from 'react';
import ReactDOM from 'react-dom';

import { browserHistory, Router, Route, IndexRoute } from 'react-router';
import App from './pages/App';
import Dashboard from './pages/Dashboard';
import Login from './pages/Login';
import Signup from './pages/Signup';
import Bible from './pages/Bible';
import Search from './pages/Search';
import Study from './pages/DirectedStudy';

const el = document.getElementById('root');
	
 ReactDOM.render(	
	<Router history={browserHistory}>
		<Route path="/" component={App}>
			<IndexRoute component={Dashboard}></IndexRoute>
			<Route path="login" component={Login} ></Route>
			<Route name="signup" path="/signup" component={Signup}></Route>
			<Route path="study" component={Study}></Route>
			<Route path="search/:term(/:page)" component={Search} ></Route>
			<Route path="bible(/:book)(/:chapter)(/:verse)" component={Bible} ></Route>
		</Route>
	</Router>, 
	el);

console.log("index.js finished");