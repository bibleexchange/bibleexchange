import React from 'react';
import SessionStore from '../stores/SessionStore';
import ProfileStore from '../stores/ProfileStore';
import { Route, RouteHandler, Link } from 'react-router';
import AuthService from '../services/AuthService';
import UserSessionControl from './UserSessionControl';
import SessionActionCreators from '../actions/SessionActionCreators';

class App extends React.Component {
 	constructor(props, context) {
		super(props, context);
		this.state = this._getState();
	}
  
  componentWillMount(){
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
	console.log('App.js rendered.', this.state.user, this.props.route);
	
	let title = 'Bible exchange';
	if(this.props.route == '/'){
		title = 'Bible exchange';
	}
	
    return (
      <div> 
		 <div className="container">
			<div className="navbar navbar-static-top">
				<div className="navbar-header pull-left">
				  <Link className="navbar-brand" to="/">
					<img className="" src="/images/be_logo.png" alt="Bible exchange logo" /> 
					{title}
				  </Link>
				</div>
				<UserSessionControl url={this.props.location.pathname} user={this.state.user} route={this.props.route}/>
			</div>
		</div>
		
        {this.props.children}
      </div>
    );
  }
  
}

App.contextTypes = {
    router: React.PropTypes.object.isRequired
};

module.exports = App;