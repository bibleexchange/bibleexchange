import React from 'react';
import Link from 'react-router/lib/Link';

class UserNotifications extends React.Component {
	
  render() {
	   let user = this.props.user;
	   
		if (user.session.isReady && user.profile.isReady) {
			
		  return  (<div>
		  <hr />
		  <Link to="/user/notifications" className="btn btn-large btn-default" style={{width:"100%"}}>
			 My Messages
		  </Link> 
			  <ul>
			  {user.profile.all.unreadNotifications.map(function(n){
				return <li key={n.id}>{n.body}</li>;
			  })};
			  </ul>
		  </div>);
		} else {
		  return null;
		}
	  
  }
  
}

module.exports = UserNotifications;