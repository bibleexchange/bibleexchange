import React from 'react';
import { Link } from 'react-router';
import SessionActionCreators from '../actions/SessionActionCreators';
import SessionStore from '../stores/SessionStore';
import BookMarkIt from './BookMarkIt';
import { Nav, NavItem } from 'react-bootstrap';

require("../stylesheets/modules/navbar.scss");

class UserLoggedIn extends React.Component {
  
  render() {  
	let user = this.props.user.profile.all;

    return (
    <Nav bsStyle="pills" activeKey={1} onSelect={this.handleSelect} pullRight>
		<NavItem eventKey={1} title="Item"><BookMarkIt url={this.props.url} token={user.token} /></NavItem>
		<NavItem eventKey={2} title="Item"><Link to="/" onClick={this.props.handleLogout} className="btn btn-default navbar-btn" >
			<img src={user.gravatar} alt={user.firstname + " " + user.lastname} style={{paddingRight:'15px'}}/>
			Logout
		</Link></NavItem>
	 </Nav>
    );
  }
}

class UserLoggedOut extends React.Component {
  render() {
    return (
		<Nav activeKey={1} onSelect={this.handleSelect} pullRight>
			<li eventKey={1} href="/home"><Link to="/login">Login</Link></li>
			<li eventKey={2} title="Item"><Link to="/signup">Signup</Link></li>
		  </Nav>
    );
  }
  
    handleSelect(selectedKey) {
	  alert('selected ' + selectedKey);
	}
	
} 

class UserSessionControl extends React.Component {
	
  render() {
    return (this.getSessionStuff(this.props.user, this.props.url));
  }
	
	getSessionStuff(user,url) {
		console.log('deciding session stuff based on: ', user);
		if (user.profile.isReady) {
			return <UserLoggedIn url={url} user={user} handleLogout={this.handleLogout.bind(this)}/>;
		}else {
		   return <UserLoggedOut />;
		}
	}
	
  handleLogout(e) {
	e.preventDefault();
    SessionActionCreators.logoutUser();
  }
  
}

module.exports = UserSessionControl;