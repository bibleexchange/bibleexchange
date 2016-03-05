import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, IndexRoute, hashHistory, browserHistory} from "react-router";

import Bible from './pages/Bible';
import Dashboard from './pages/Dashboard';
import Layout from './pages/layout';
import Search from './pages/Search';
import Study from './pages/DirectedStudy';

const app = document.getElementById('root');
			
ReactDOM.render(
	<Router history={browserHistory}>
		<Route path="/" component={Layout}>
			<IndexRoute component={Dashboard}></IndexRoute>
			<Route path="study" component={Study}></Route>
			<Route path="search/:term(/:page)" component={Search} ></Route>
			<Route path="bible(/:book)(/:chapter)" component={Bible} ></Route>
		</Route>
	</Router>,
	app);