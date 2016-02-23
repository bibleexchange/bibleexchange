import React from 'react';
import MainNav from '../components/Navigation/Main';
import Footer from '../components/Navigation/Footer';

class Layout extends React.Component {
	
    constructor(props) {
		super(props);	
	}
	
  render() {
	  
	const data = {
		user: {
			notifications:{
				unread:['test message']
			},
			isAdmin:false,
			auth:false
		},
		section: {
			id:2,
			title:'study'
		}
	};
	  
    return (
      <div>
       <MainNav user={data.user}/>
	   
		{this.props.children}
	   
	   <Footer user={data.user}/>
      </div>
    )
  }
}

module.exports = Layout;