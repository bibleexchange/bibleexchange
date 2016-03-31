import React from 'react';
import Link from 'react-router/lib/Link';

class UserNotifications extends React.Component {
	
  render() {
	   const user = this.props.user;
	   
		if (user.isReady) {
			
		  return  (<div>
		  <hr />
		  <Link to="/user/notifications" className="btn btn-large btn-default" style={{width:"100%"}}>
			 <img src={user.details.gravatar} alt={user.details.firstname + " " + user.details.lastname}/>
			 Notifications
		  </Link> 
			  <ul>
			  {user.details.unreadNotifications.map(function(n){
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