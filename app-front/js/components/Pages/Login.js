import React from 'react';
import { Link } from 'react-router';
import LoginActionCreators from '../../actions/LoginActionCreators';
import LoginStore from '../../stores/LoginStore';
import GoHomeComponent from '../Partials/GoHome';

class Login extends React.Component {

  constructor() {
    super()
	
	this.state = this._getBeforeLoginState();	
	console.log("Login loaded");
  }
	
    _getBeforeLoginState() {
      return {
		user: LoginStore.isLoggedIn(),
		password: '',
		errors:LoginStore.error
      };
    }
	
	componentDidMount() {
      this.changeListener = this._onChange.bind(this);
      LoginStore.addChangeListener(this.changeListener);
    }

    _onChange() {
      this.setState(this._getBeforeLoginState());
    }

    componentWillUnmount() {
      LoginStore.removeChangeListener(this.changeListener);
    }
	
  //action
  login(e) {
    e.preventDefault();
    LoginActionCreators.loginUser(this.state.user, this.state.password);
  }
  
  handleUserChange(event) {
    this.setState({user: event.target.value});
  }
  
  handlePasswordChange(event) {
    this.setState({password: event.target.value});
  }
  
  render() {
	  
	const errors = this.state.errors.map((err)=>{
		return <li key={Math.random()}>{err.message}</li>;
	});
	 
    return (
		<div>
			<div className="container">
				<GoHomeComponent />
			</div>
			<div className="container">
				<div className="login jumbotron center-block">
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
			</div>
		</div>
    );
  }
}

module.exports = Login;