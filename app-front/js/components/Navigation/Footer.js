import React from 'react';

class Footer extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  userAuth(user){
	  
	if (user.auth){		
		return '';
	}else{
		return '<a href="/register">Register</a>';		
	}
	  
  }
  
  render() {
	  
	var user = this.props.user;
	
    return (
		<footer id="footer" className="bottom navbar-primary">
			<div className="row">
				<div className="col-md-4">
					<h3><span className="glyphicon glyphicon-link"></span>  Navigation</h3>
					<p><a href="/">Home</a><br/>
						<a href="/index">Courses</a><br/>
						<a href="/members">Members</a><br/>
						<span dangerouslySetInnerHTML={{__html: this.userAuth(user)}} ></span>	
						
					</p>	
				</div>
				<div className="col-md-4">
					<h3><span className="glyphicon glyphicon-envelope"></span> Contact</h3>
					<p><a href="mailto:info@deliverance.me?Subject=DBIonline" target="_top">info@deliverance.me</a></p>
					<p>1008 Congress Street Portland, Maine 04102</p>
				</div>
				<div className="col-md-4">
					<h3><span className="glyphicon glyphicon-info-sign"></span> Information</h3>
				</div>
			</div>
		</footer>			

    )
  }
}

module.exports = Footer;