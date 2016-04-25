import React from 'react';
import SessionStore from '../stores/SessionStore';
import ProfileStore from '../stores/ProfileStore';
import { Route, RouteHandler, Link } from 'react-router';
import RequestService from '../util/RequestService';
import UserSessionControl from './UserSessionControl';
import SessionActionCreators from '../actions/SessionActionCreators';
import AppConstants from '../util/AppConstants';
import Loading from './Loading';

import { Navbar, Nav, NavItem, NavDropdown, MenuItem } from 'react-bootstrap';
require('../stylesheets/modules/banner.scss');
require('../stylesheets/utilities/typography.scss');
require('../node_modules/bootstrap/dist/css/bootstrap.css');

class App extends React.Component {
  
  componentWillMount(){
	  
	 this.state = this._getState();
	  
	 let token = SessionStore.hasJWT();
		
		if(token){
			console.log('&*&*&* AUTO CHECKING USER WITH LOCAL STORAGE.');
			SessionActionCreators.getUser(token);
		} 
  }
  
  _getState() {
		return {
			user: {
				session: SessionStore.getState(),
				profile: ProfileStore.getState()
				}
			};
  }
  
 componentDidMount() {
    this.changeListener = this._onChange.bind(this);
    SessionStore.addChangeListener(this.changeListener);
	ProfileStore.addChangeListener(this.changeListener);
  }

   _onChange() {
    let newState = this._getState();
    this.setState(newState);	
  }
	
  componentWillUnmount() {
    SessionStore.removeChangeListener(this.changeListener);
	ProfileStore.removeChangeListener(this.changeListener);
  }

  render() {  
	let title = AppConstants.SITE_TITLE;

    return (
      <div> 
	    <Navbar staticTop>
			<Navbar.Header>
			  <Navbar.Brand>
				 <Link to="/"><img className="" src="/images/be_logo.png" alt="Bible exchange logo" /> 
					{title}
				  </Link>
			  </Navbar.Brand>
			</Navbar.Header>
			<UserSessionControl url={this.props.location.pathname} user={this.state.user} route={this.props.route}/>
		  </Navbar>
		{this.props.children}
      </div>
    );
  }	
}

App.contextTypes = {
    router: React.PropTypes.object.isRequired
};

module.exports = App;