import React from 'react';
import { browserHistory } from 'react-router';
import SessionActionCreators from '../../actions/SessionActionCreators';
import SessionStore from '../../stores/SessionStore';

class LoginForm extends React.Component {

  constructor() {
    super()
	this.state = this._getBeforeLoginState();	
  }
	
    _getBeforeLoginState() {
      return {
		user: '',
		password: '',
		errors:SessionStore.errors,
		loggedIn: SessionStore.loggedIn()
      };
    }
	
	componentDidMount() {
      this.changeListener = this._onChange.bind(this);
      SessionStore.addChangeListener(this.changeListener);
    }

    _onChange() {		
      this.setState(this._getBeforeLoginState());
    }

    componentWillUnmount() {
      SessionStore.removeChangeListener(this.changeListener);
    }
	
	componentDidUpdate(){
		if(this.state.loggedIn){
			console.log('already logged in now set up a redirect OK?'); 
			browserHistory.push('/');
		}
	}
	
  //action
  login(e) {
    e.preventDefault();
    SessionActionCreators.loginUser(this.state.user, this.state.password);
  }
  
  handleUserChange(event) {
    this.setState({user: event.target.value});
  }
  
  handlePasswordChange(event) {
    this.setState({password: event.target.value});
  }
    
  render() {

	const errors = !this.state.errors ? "":this.state.errors.map((err)=>{
		return <li key={Math.random()}>{err.message}</li>;
	});
	
    return (
			<div>
				<h1>Login</h1>
				<ul style={{color:"red"}}>{errors}</ul>
				
				<form role="form">
				<div className="form-group">
				  <label htmlFor="email">Email</label>
				  <input type="text" onChange={this.handleUserChange.bind(this)} value={this.state.user} className="form-control" id="email" placeholder="email" />
				</div>
				<div className="form-group">
				  <label htmlFor="password">Password</label>
				  <input type="password" onChange={this.handlePasswordChange.bind(this)} value={this.state.password} className="form-control" id="password" ref="password" placeholder="Password" />
				</div>
				<button type="submit" className="btn btn-default" onClick={this.login.bind(this)}>Submit</button>
			  </form>
			</div>
    );
  }
}

module.exports = LoginForm;