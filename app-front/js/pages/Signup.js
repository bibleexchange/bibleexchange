import React from 'react';
import LoginActionCreators from '../actions/LoginActionCreators';

class Signup extends React.Component {

  constructor() {
    super()
    this.state = {
      user: '',
      password: '',
      extra: ''
    };
	
	console.log("Signup loaded");
  }

  signup(e) {
    e.preventDefault();
    LoginActionCreators.signup(this.state.user, this.state.password, this.state.extra)
  }
  
  handleChange(event,field) {
    this.setState({field: event.target.value});
  }
  
  render() {
    return (
      <div className="login jumbotron center-block">
        <h1>Signup</h1>
        <form role="form">
        <div className="form-group">
          <label htmlFor="username">Username</label>
          <input type="text" onChange={this.handleChange('user')} value={this.state.user} className="form-control" id="username" placeholder="Username" />
        </div>
        <div className="form-group">
          <label htmlFor="password">Password</label>
          <input type="password" onChange={this.handleChange('password')} value={this.state.password} className="form-control" id="password" ref="password" placeholder="Password" />
        </div>
        <div className="form-group">
          <label htmlFor="extra">Extra</label>
          <input type="text" onChange={this.handleChange('extra')} value={this.state.extra} className="form-control" id="password" ref="password" placeholder="Some extra information" />
        </div>
        <button type="submit" className="btn btn-default" onClick={this.signup.bind(this)}>Submit</button>
      </form>
    </div>
    );
  }
}

module.exports = Signup;