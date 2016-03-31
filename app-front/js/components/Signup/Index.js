import React from 'react';
import SessionActionCreators from '../../actions/SessionActionCreators';

class SignupIndex extends React.Component {

  constructor() {
    super();
	this.state = this._getSignupState();	
  }

    _getSignupState() {
      return {
		email: '',
		password: '',
		extra:'',
		message:{code:'', body:''}
      };
    }
  
  signup(e) {
    e.preventDefault();
    SessionActionCreators.signup(this.state.email, this.state.password, this.state.extra)
  }
  
  handleChange(event,field) {
	 console.log(event);
    this.setState({field: event.target.value});
  }
  
  handleEmailChange(event) {
    this.setState({email: event.target.value});
  }
  
  handlePasswordChange(event) {
    this.setState({password: event.target.value, extra:''});
  }
  handleExtraChange(event) {
    this.setState({extra: event.target.value});
	
	if(event.target.value !== this.state.password){
		this.setState({message : {code:'error', body:'Passwords do not match :('}});
	}else{
		this.setState({message : {code:'good', body:'We have a match :) Great Work!'}});
	}
	
	this.forceUpdate();
	
  }
  
  messageSetup(){
	if(this.state.message.code === "error"){
		return <p style={{color:"red"}}>{this.state.message.body}</p>
	}else if(this.state.message.code === "good"){
		return <p style={{color:"green"}}>{this.state.message.body}</p>
	}
	return <p>&nbsp;</p>;
  }
  
  render() {
	  
	let message = this.messageSetup();
	  
    return (
		<div className="container">
		  <div className="login jumbotron center-block">
			<h1>Signup</h1>
			
			{message}
			
			<form role="form">
			<div className="form-group">
			  <label htmlFor="email">Email</label>
			  <input type="text" onChange={this.handleEmailChange.bind(this)} value={this.state.email} className="form-control" id="email" placeholder="email" />
			</div>
			<div className="form-group">
			  <label htmlFor="password">Password</label>
			  <input type="password" onChange={this.handlePasswordChange.bind(this)} value={this.state.password} className="form-control" id="password" ref="password" placeholder="Password" />
			</div>
			<div className="form-group">
			  <label htmlFor="extra">Retype Password</label>
			  <input type="password" onChange={this.handleExtraChange.bind(this)} value={this.state.extra} className="form-control" id="password" ref="password" placeholder="confirm password" />
			</div>
			<button type="submit" className="btn btn-default" onClick={this.signup.bind(this)}>Submit</button>
		  </form>
		</div>
	</div>
    );
  }
}

module.exports = SignupIndex;