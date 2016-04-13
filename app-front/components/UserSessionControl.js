import React from 'react';
import { Link } from 'react-router';
import SessionActionCreators from '../actions/SessionActionCreators';
import SessionStore from '../stores/SessionStore';
import BookMarkIt from './BookMarkIt';

class UserLoggedIn extends React.Component {
  
  render() {  
	let user = this.props.user.profile.all;

    return (
     <div className="navbar-header pull-right">
		<BookMarkIt url={this.props.url} token={user.token} />
		<Link to="/" onClick={this.props.handleLogout} className="btn btn-default navbar-btn" >
			<img src={user.gravatar} alt={user.firstname + " " + user.lastname} style={{paddingRight:'15px'}}/>
			Logout
		</Link>
	</div>
    );
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
    return (
     <span>{this.getSessionStuff(this.props.user, this.props.url)}</span> 
    );
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