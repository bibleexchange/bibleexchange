import React from 'react';
import LoginStore from '../stores/LoginStore';
import { browserHistory, Link } from 'react-router';
import Loading from './Partials/Loading'

class App extends React.Component {
 
  constructor(props, context) {
    super(props, context);
    //set initial state dircetly when extending React.Component
    //use getInitialState hook when using React.createClass();
    this.state = this._getLoginState();	
	console.log("App loaded");
  }
  
  _getLoginState() {
    return {
      userLoggedIn: LoginStore.isLoggedIn()
    };
  }

  componentDidMount() {
    //register change listener with LoginStore
    this.changeListener = this._onLoginChange.bind(this);
    LoginStore.addChangeListener(this.changeListener);
  }

  /*
    This event handler deals with all code-initiated routing transitions
    when logging in or logging out
  */
  _onLoginChange() {
    //get a local up-to-date record of the logged-in state
    //see https://facebook.github.io/react/docs/component-api.html
    let userLoggedInState = this._getLoginState();
    this.setState(userLoggedInState);

    let transitionPath = '/';

    console.log("&*&*&* App onLoginChange event: loggedIn=", userLoggedInState.userLoggedIn,
      "nextTransitionPath=", transitionPath);

    if(userLoggedInState.userLoggedIn){
		console.log('logged in');
		browserHistory.push(transitionPath)
    }else{
		console.log('not logged in');
		browserHistory.push('/login');
    }
  }

  componentWillUnmount() {
    LoginStore.removeChangeListener(this.changeListener);
  }

  render() {
	  
    return (
      <div> 
        {this.props.children}
      </div>
    );
  }
  
}

module.exports = App;