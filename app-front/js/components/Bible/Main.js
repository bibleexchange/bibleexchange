import React from 'react';
import MainNavigation from '../Navigation/Main';
import MainFooter from '../Navigation/Footer';

class Main extends React.Component {
	
	constructor(props) {
		super(props);
		this.state = {
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
	}
	
	
  render() {
    return (
      <div>
		
		<MainNavigation user={this.state.user} activeSection={this.state.section.title}/>
		
		<h1>HI me ohoo</h1>
		
		<MainFooter  user={this.state.user}/>
      </div>
    )
  }
}

module.exports = Main;