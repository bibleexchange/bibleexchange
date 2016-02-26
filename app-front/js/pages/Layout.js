import React from 'react';
import MainNav from '../components/Navigation/Main';
import Footer from '../components/Navigation/Footer';
import UserStore from '../stores/UserStore';

class Layout extends React.Component {
	
    constructor(props) {
		super(props);	
	}
	
  render() {
	  
	const data = {
		user: UserStore.getAuthorizedUser(),
		section: {
			id:2,
			title:'study'
		}
	};
	
	const { location } = this.props;
	
    return (
      <div>
       <MainNav user={data.user} location={location}/>
		  
		{this.props.children}
	   
	   <Footer user={data.user}/>
      </div>
    )
  }
}

module.exports = Layout;