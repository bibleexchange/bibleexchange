import React from 'react';
import MainNavigation from '../Navigation/Main';
import MainFooter from '../Navigation/Footer';
import DirectoryOfStudies from './DirectoryOfStudies';

class Index extends React.Component {
	
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
      <div className="Image">
		
		<MainNavigation user={this.state.user} activeSection={this.state.section.title}/>
		
		<DirectoryOfStudies />
		
		<MainFooter  user={this.state.user}/>
      </div>
    )
  }
}

module.exports = Index;