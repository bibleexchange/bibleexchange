import React from 'react';
import { Link } from 'react-router';
import LoginStore from '../stores/LoginStore';
import UserStore from '../stores/UserStore';
import NotificationStore from '../stores/NotificationStore';
import LoginActionCreators from '../actions/LoginActionCreators';
import UserActionCreators from '../actions/UserActionCreators';

class Dashboard extends React.Component {
	
    constructor(props) {
		super(props);	
		this.state = this._getDashboardState();	
		console.log("Dashboard loaded");
	}
	
	_getDashboardState() {
    return {
      currentUser: LoginStore.isLoggedIn(),
	  token: LoginStore.jwt,
	  user: UserStore.getAuthorizedUser(),
	  notifications: NotificationStore.getAll()
    };
  }
  
 componentDidMount() {
    //register change listener with LoginStore
    this.changeListener = this._onChange.bind(this);
	
    LoginStore.addChangeListener(this.changeListener);
	UserStore.addChangeListener(this.changeListener);
	console.log(this.state.currentUser);
	UserActionCreators.getUser(this.state.token);
  }

  /*
    This event handler deals with all code-initiated routing transitions
    when logging in or logging out
  */
  _onChange() {
    let dashboardState = this._getDashboardState();
    this.setState(dashboardState);
  }

  componentWillUnmount() {
    LoginStore.removeChangeListener(this.changeListener);
	UserStore.removeChangeListener(this.changeListener);
  }
	
  render() {
	
    return (
      <div>
		<div className="container">
		 {this.SessionStuff}
		 <hr />
		 <Link to="/bible" >Bible</Link>
		 </div>
      </div>
    )
  }
  
  get SessionStuff() {
    if (!this.state.user.auth) {
      return (
      <ul>
		<h2>Account</h2>
        <li><Link to="login">Login</Link></li>
        <li><Link to="signup">Signup</Link></li>
      </ul>)
    } else {
      return (
      <div>
	  <ul>
	  <img src={this.state.user.gravatar} alt={this.state.user.firstname + " " + this.state.user.lastname}/>
	  <h1>{this.state.user ? this.state.user.firstname + '\'s Dashboard' : ''}</h1>
        <li>
          <Link to="/" onClick={this.logout}>Logout</Link>
        </li>
      </ul>
	  <ul>
	  <h2>Notifications</h2>
	  {this.state.user.unreadNotifications.map(function(n){
		return <li key={n.id}>{n.body}</li>;
	  })};
	  </ul>
	  </div>)
    }
  }
  
  logout(e) {
    e.preventDefault();
    LoginActionCreators.logoutUser();
  }
  
}

module.exports = Dashboard;