import React from 'react';
import { Link } from 'react-router';

class GithubNote extends React.Component {
	
  render() { 
	let note = this.props.data;
	  
	return (
		<div>
			<h3><Link to={note.path}>{note.name}</Link></h3>
		</div>
		);
	}
  
}

module.exports = GithubNote;