import React from 'react';
import ReactDOM from 'react-dom';
import browserHistory from 'react-router/lib/browserHistory';
import Router from 'react-router/lib/Router';
import routes from './routes';
 
const Routes = (
  <Router history={browserHistory} >
    { routes }
  </Router>
)

const app = document.getElementById('root');
ReactDOM.render(Routes, app);