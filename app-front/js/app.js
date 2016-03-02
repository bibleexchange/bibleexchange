import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, IndexRoute, hashHistory, browserHistory} from "react-router";

import Bible from './pages/Bible';
import Dashboard from './pages/Dashboard';
import Study from './pages/DirectedStudy';
import Layout from './pages/layout';

const app = document.getElementById('root');
			
ReactDOM.render(
	<Router history={browserHistory}>
		<Route path="/" component={Layout}>
			<IndexRoute component={Dashboard}></IndexRoute>
			<Route path="study" component={Study}></Route>
			<Route path="bible(/:book)(/:chapter)" component={Bible} ></Route>
		</Route>
	</Router>,
	app);