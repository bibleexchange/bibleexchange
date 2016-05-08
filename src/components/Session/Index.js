import React from 'react';
import { Link, browserHistory } from 'react-router';
import SessionActionCreators from '../../actions/SessionActionCreators';
import SessionStore from '../../stores/SessionStore';

class SessionIndex extends React.Component {
  
  render() {

	const errors = !this.state.errors ? "":this.state.errors.map((err)=>{
		return <li key={Math.random()}>{err.message}</li>;
	});
	
    return (
			<div className="container">
				<div className="login jumbotron center-block">
				{this.props.children}
				</div>
			</div>
    );
  }
}

module.exports = SessionIndex;