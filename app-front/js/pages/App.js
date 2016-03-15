/*
import React from 'react';
import MainNav from '../components/Navigation/Main';
import Footer from '../components/Navigation/Footer';
import UserStore from '../stores/UserStore';

class App extends React.Component {
	
    constructor(props) {
		super(props);	
	}
	
  render() {
	  
	const data = {
		user: UserStore.getAuthorizedUser(),
		section: {
			id:2,
			title:'study'
		}
	};
	
	const { location } = this.props;
	
    return (
      <div>
       <MainNav user={data.user} location={location}/>
		  
		{this.props.children}
	   
	   <Footer user={data.user}/>
      </div>
    )
  }
}

module.exports = App;
*/
import React from 'react';
import LoginStore from '../stores/LoginStore';
import RouterStore from '../stores/RouterStore';
import { Link } from 'react-router';

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

    //get any nextTransitionPath - NB it can only be got once then it self-nullifies
    let transitionPath = RouterStore.nextTransitionPath || '/';

    //trigger router change
    console.log("&*&*&* App onLoginChange event: loggedIn=", userLoggedInState.userLoggedIn,
      "nextTransitionPath=", transitionPath);

    if(userLoggedInState.userLoggedIn){
		console.log('logged in');
		this.context.router.push(transitionPath)
    }else{
		console.log('not logged in');
		this.context.router.push('/login')
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

App.contextTypes = {
  router: React.PropTypes.object.isRequired
};

module.exports = App;