import React from 'react';
import { Link } from 'react-router';

class GithubDirectory extends React.Component {
	
  render() { 
	let c = this.props.course;
	  
	return (
		<li><Link to={this.props.base_path+c.path}>{c.name}</Link></li>
		);
	}
  
}

module.exports = GithubDirectory;