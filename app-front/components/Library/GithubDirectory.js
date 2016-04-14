import React from 'react';
import { Link } from 'react-router';

class GithubDirectory extends React.Component {
	
  render() { 
	let c = this.props.course;
	  
	return (
		<div>
			<h3><Link to={c.path}>{c.name}</Link></h3>
		</div>
		);
	}
  
}

module.exports = GithubDirectory;