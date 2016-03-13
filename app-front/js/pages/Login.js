import React from 'react';
import LoginActionCreators from '../actions/LoginActionCreators';

class Login extends React.Component {

  constructor() {
    super()
    this.state = {
      user: '',
      password: ''
    };
	
	console.log("Login loaded");
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
    return (
      <div className="login jumbotron center-block">
        <h1>Login</h1>
        <form role="form">
        <div className="form-group">
          <label htmlFor="username">Username</label>
          <input type="text" onChange={this.handleUserChange.bind(this)} value={this.state.user} className="form-control" id="username" placeholder="Username" />
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

module.exports = Login;