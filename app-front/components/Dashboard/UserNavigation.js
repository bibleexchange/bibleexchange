import React from 'react';
import Link from 'react-router/lib/Link';
import UserNotifications from './UserNotifications';

class UserNavigation extends React.Component {
	
  render() {
	  
	 const nav = this.props.nav; 

    return (
     <div className="container-fluid">	
			<div className="row">
				<div className="col-md-8 col-md-offset-2">
					
					<UserNotifications user={this.props.user}/>
					<hr />
					<Link to="/bible" className="btn btn-large btn-default" style={{width:"100%"}}>Holy Bible</Link> 
					<ul>
					{nav.bible.map(function(nav,index){
						return (<li key={index}><Link to={nav.url}>{nav.title}</Link></li>);
					})};
					</ul>
					<hr />
					<Link to="/library" className="btn btn-large btn-default" style={{width:"100%"}}>Library</Link>
					 <hr />
					 {this.myLibrary()}
				</div>
			</div>
		</div>
    );
  }
  
  myLibrary(){
	  if(this.props.user.session.isReady && this.props.user.profile.isReady){
		return <div><Link to="/user/notebooks" className="btn btn-large btn-default" style={{width:"100%"}}>My Notebooks &amp; Notes</Link><hr /></div>;
	 }
  }
  
}

module.exports = UserNavigation;