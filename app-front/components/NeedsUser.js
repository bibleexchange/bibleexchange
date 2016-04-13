import React from 'react';
import SessionStore from '../stores/SessionStore';
import UserStore from '../stores/UserStore';

class NeedsUser extends React.Component {

	constructor(){	
		this.user = UserStore.getAll();
		this.session = SessionStore.getAll();
		
		if(!this.session.loggedIn){
			return null;
		}
		
	}

}

module.exports = NeedsUser;