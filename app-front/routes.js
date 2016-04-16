// routes.js
import React from 'react';
import IndexRoute from 'react-router/lib/IndexRoute';
import Route from 'react-router/lib/Route';
import App from './components/App';
 
// Pages
import Bible from './components/Bible/Index';
import BibleChapterPage from './components/Bible/BibleChapterPage';
import BibleVersePage from './components/Bible/BibleVersePage';
import Dashboard from './components/Dashboard/Index';

import Library from './components/Library/Index';
import Notebook from './components/Library/Notebook';
import Note from './components/Library/Note';

import NotebookEditor from './components/NotebookEditor/Index';
import NoteEditor from './components/NoteEditor/Index';
import Login from './components/Session/Index';
import NoMatch from './components/NoMatch';
import Search from './components/Search/Index';
import Signup from './components/Signup/Index';

import UserLibrary from './components/UserLibrary/Index';

export default (
	<Route path="/" component={App}>
		<IndexRoute component={Dashboard}></IndexRoute>
		<Route path="login" component={Login} ></Route>
		<Route name="signup" path="/signup" component={Signup}></Route>
		<Route path="search/:term(/:page)" component={Search} ></Route>				
		<Route path="bible" component={Bible} >
			<Route path=":book/:chapter/:verse" component={BibleVersePage}></Route>
			<Route path=":book/:chapter" component={BibleChapterPage}></Route>
		</Route>
		<Route path="user" component={UserLibrary} >
			<Route path="notebook/:id" component={NotebookEditor}></Route>
			<Route path="note/create(/:reference)" component={NoteEditor}></Route>
			<Route path="note/:note/edit" component={NoteEditor}></Route>
		</Route>

		<Route path="library" component={Library}></Route>
		<Route path="library/:notebook" component={Notebook}></Route>
		<Route path="library/:notebook/:note" component={Note}></Route>
		
		<Route path="*" component={NoMatch}/>
	</Route>
);