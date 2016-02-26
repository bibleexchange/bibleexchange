import Jquery from "jquery";
import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, IndexRoute, hashHistory} from "react-router";

import Bible from './pages/Bible';
import Dashboard from './pages/Dashboard';
import Study from './pages/DirectedStudy';
import Layout from './pages/layout';

const app = document.getElementById('root');
const chapter = {
				reference:'Matthew 1',
				previousURL:'/bible/malachi/1',
				nextURL:'/bible/matthew/2'
			};
			
ReactDOM.render(
	<Router history={hashHistory}>
		<Route path="/" component={Layout}>
			<IndexRoute component={Dashboard}></IndexRoute>
			<Route path="study" component={Study}></Route>
			<Route path="bible(/:book)(/:chapter)" component={Bible} data={chapter}></Route>
		</Route>
	</Router>,
	app);