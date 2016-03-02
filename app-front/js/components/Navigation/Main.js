import React from 'react';
import MainSearchForm from './SearchForm';
import { Link } from "react-router";

class Main extends React.Component {
  
    constructor(props) {
		super(props);	
		 this.state = {
			  collapsed: true,
			};
		this.toggleBar(this.props.user);

  }
	
  toggleCollapse() {
    const collapsed = !this.state.collapsed;
    this.setState({collapsed});
  }
  toggleCollapseAlways() {
    const collapsed = true;
    this.setState({collapsed});
  }
  
  toggleBar(user){
	if (user.auth){
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
	const { location } = this.props;
    const { collapsed } = this.state;
    const homeClass = location.pathname === "/" ? "home active" : "home";
    const bibleClass = location.pathname.match(/^\/bible/) ? "bible active" : "bible";
    const studyClass = location.pathname.match(/^\/study/) ? "study active" : "study";
    const navClass = collapsed ? "collapse" : "";
	const user = this.props.user;
	
    return (
  <nav id="menu" className="navbar navbar-default navbar-static-top animated" style={{top:0}}>
        <div className="container-fluid">
          <div className="navbar-header">
	         
            <button id="menu-toggle" type="button" className="navbar-toggle borderless-button" data-target="#navbar" onClick={this.toggleCollapse.bind(this)}>       
				{this.toggleBar(user)}
			</button>
			
            <a id="be-logo" className="navbar-brand" href="/"><img src="/assets/svg/be-logo.svg" /><span className="hidden-xs">Bible exchange<sup className="beta">beta</sup></span></a>
			
             <ul className="nav navbar-nav pull-left">
						
						<li dangerouslySetInnerHTML={{__html: this.adminLink(user.isAdmin)}} ></li>
						
						<li className={homeClass}>
							<Link to="/"  onClick={this.toggleCollapseAlways.bind(this)}>
								<span className="glyphicon glyphicon-home" aria-hidden="true" ></span> <span className="hidden-sm hidden-xs"> Dashboard </span>
								<sup className="badge badge-warning">{this.unreadNotifications(user)}</sup>
							</Link>
						</li>
						<li className={bibleClass}>
							<Link to="/bible" onClick={this.toggleCollapseAlways.bind(this)}>
								<span className="glyphicon glyphicon-book" aria-hidden="true"></span> <span className="hidden-sm hidden-xs"> Bible</span>
							</Link>
						</li>
						<li className={studyClass} >
							<Link to="/study" onClick={this.toggleCollapseAlways.bind(this)}>
								<span className="glyphicon glyphicon-th-large" aria-hidden="true"></span> <span className="hidden-sm hidden-xs"> Study</span>
							</Link>
						</li>
						
						<li className="search hidden-xs">
							<MainSearchForm />
						</li>
						
	        	</ul> 
				
          </div> 
		  	  <div id="navbar" className={"navbar-collapse " + navClass}>
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