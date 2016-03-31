import React from 'react';
import { Link, browserHistory } from 'react-router';
import SessionActionCreators from '../actions/SessionActionCreators';
import SessionStore from '../stores/SessionStore';

class UserLoggedIn extends React.Component {

  render() {  
	const user = this.props.user.details;

    return (
     <div className="navbar-header pull-right">
		<Link to="/" onClick={this.handleLogout} className="btn btn-default navbar-btn" >
			<img src={user.gravatar} alt={user.firstname + " " + user.lastname} style={{paddingRight:'15px'}}/>
			Logout
		</Link>
	</div>
    );
  }
  
  handleLogout(e) {
	e.preventDefault();
    SessionActionCreators.logoutUser();
    browserHistory.push('/login');
  }
  
}

class UserLoggedOut extends React.Component {

  render() {
    return (
		<div className="navbar-header pull-right">
			<Link to="/login" className="btn btn-default navbar-btn" >Login</Link>
			<Link to="/signup" className="btn btn-default navbar-btn" style={{marginLeft:'15px',marginRight:'15px'}}>Signup</Link>
		 </div>
    );
  }
} 

class UserSessionControl extends React.Component {

  render() {
	  console.log(this.props.user);
    return (
     <span>{this.getSessionStuff(this.props.user)}</span> 
    );
  }
	
	getSessionStuff(user) {
   
		if (user.isReady) {
			return <UserLoggedIn user={user} />;
		} else {
		   return <UserLoggedOut />;
		}
	}	
}

module.exports = UserSessionControl;