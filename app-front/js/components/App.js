import React from 'react';
import SessionStore from '../stores/SessionStore';
import { Route, RouteHandler, Link } from 'react-router';
import AuthService from '../services/AuthService';
import UserSessionControl from './UserSessionControl';
import SessionActionCreators from '../actions/SessionActionCreators';

class App extends React.Component {
 	constructor(props) {
		super(props);	
		this.state = this._getState();	
		
		let token = SessionStore.isJWT();

		if(token){
			console.log('** ATTEMPTING AUTO LOGIN...');
			SessionActionCreators.getUser(token);
		}
	}
	
  _getState() {
		return SessionStore.getState();
  }
	
 componentDidMount() {
    this.changeListener = this._onChange.bind(this);
    SessionStore.addChangeListener(this.changeListener);
  }

   _onChange() {
    let newState = this._getState();
    this.setState(newState);
  }

  componentWillUnmount() {
    SessionStore.removeChangeListener(this.changeListener);
  }
 
  render() {
    return (
      <div> 
		 <div className="container">
			<div className="navbar navbar-static-top">
				<div className="navbar-header pull-left">
				  <Link className="navbar-brand" to="/">
					<img className="" src="/images/be_logo.png" alt="Bible exchange logo" /> 
					Home
				  </Link>
				</div>
				<UserSessionControl  user={this.state}/>
			</div>
		</div>
		
        {this.props.children}
      </div>
    );
  }
  
}

module.exports = App;