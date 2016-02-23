import React from 'react';
import MainSearchForm from './SearchForm';
import { Link } from "react-router";

class Main extends React.Component {
  
    constructor(props) {
		super(props);	
		
		this.toggleBar(this.props.user);

  }

  toggleBar(user){
	if (user){
		return (
			<div>
			<div className="nav-gravatar" src={user.gravatar} alt={user.username} ></div>
			<span className="hidden-xs hidden-sm">{user.firstname}</span>
			</div>
		)
	} else {
		return (
			<div>
				<span className="sr-only">Toggle navigation</span>
				<span className="icon-bar"></span>
				<span className="icon-bar"></span>
				<span className="icon-bar"></span>
			</div>
		)
	}  
 }
	
  adminLink(isAdmin){
	if (isAdmin)
	{
		return "<li className='admin active'><a href='/admin'><span class='glyphicon glyphicon-lock' aria-hidden='true'></span> Admin</a></li>";
	}else{
		return '';
	}
  }
  
  userAuth(user){
	  
	if (user.auth){		
		return '<div><div class="hidden-md hidden-lg hidden-xl"></div><li class="divider"></li><li><a href="/auth/log-out">Log Out</a></li></div>';
	}else{
		return '<li><a href="/auth/log-in"><span class="glyphicon glyphicon-lock"></span> <span>Log In</span></a></li><li><a href="/auth/register"><span class="glyphicon glyphicon-star-empty"></span> <span>Register</span></a></li>';		
	}
	  
  }
  
	unreadNotifications(user){	  
		if (user){			
			if (user.notifications.unread.length >= 1){
				return user.notifications.unread.length;
			}
		}
	}
  
  render() {
	  
	var user = this.props.user;
	
    return (
  <nav id="menu" className="navbar navbar-default navbar-static-top animated" style={{top:0}}>
        <div className="container-fluid">
          <div className="navbar-header">
	         
            <button id="menu-toggle" type="button" className="navbar-toggle collapsed borderless-button" data-toggle="collapse" aria-expanded="false" data-target="#navbar" aria-controls="navbar">       
				{this.toggleBar(user)}
			</button>
			
            <a id="be-logo" className="navbar-brand" href="/"><img src="/assets/svg/be-logo.svg" /><span className="hidden-xs">Bible exchange<sup className="beta">beta</sup></span></a>
			
             <ul className="nav navbar-nav pull-left">
						
						<li dangerouslySetInnerHTML={{__html: this.adminLink(user.isAdmin)}} ></li>
						
						<li className="home">
							<Link to="/">
								<span className="glyphicon glyphicon-home" aria-hidden="true" ></span> <span className="hidden-sm hidden-xs"> Dashboard </span>
								<sup className="badge badge-warning">{this.unreadNotifications(user)}</sup>
							</Link>
						</li>
						<li className="bible">
							<Link to="bible">
								<span className="glyphicon glyphicon-book" aria-hidden="true"></span> <span className="hidden-sm hidden-xs"> Bible</span>
							</Link>
						</li>
						<li className="courses">
							<Link to="study">
								<span className="glyphicon glyphicon-th-large" aria-hidden="true"></span> <span className="hidden-sm hidden-xs"> Study</span>
							</Link>
						</li>
						
						<li className={"search " + this.searchActive + " hidden-xs"}>
							<MainSearchForm />
						</li>
						
	        	</ul> 
				
          </div> 
		  	  <div id="navbar" className="navbar-collapse collapse">
				<ul id="collapsible-menu" className="nav navbar-nav navbar-right">
					<div dangerouslySetInnerHTML={{__html: this.userAuth(user)}} ></div>				
				</ul>
			  </div>
        </div>
      </nav>
    )
  }
}

module.exports = Main;