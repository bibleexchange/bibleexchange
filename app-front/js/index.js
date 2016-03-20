// index.js but convention is: app-client.js when isomorphic
import React from 'react';
import ReactDOM from 'react-dom';
import { Router, browserHistory } from 'react-router';

// Routes
import routes from './routes';

const Routes = (
  <Router history={browserHistory}>
    { routes }
  </Router>
)

const app = document.getElementById('root');
ReactDOM.render(Routes, app);

console.log("index.js finished");