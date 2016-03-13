import React from 'react';
//import AuthenticatedComponent from './AuthenticatedComponent'

class Dashboard extends React.Component {
	
    constructor(props) {
		super(props);	
		console.log("Dashboard loaded");
	}
	
  render() {	  
    return (
      <div>
  <h1>{this.props.user ? this.props.user.username + '\'s Dashboard' : ''}</h1>
        <p>blah blah</p>
      </div>
    )
  }
}

//module.exports = AuthenticatedComponent(Dashboard);
module.exports = Dashboard;