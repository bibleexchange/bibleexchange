import React from 'react';
import { Link } from 'react-router';

class GithubNoteFull extends React.Component {
	
  render() { 
	let note = this.props.data;
	  
	return (
	<div>
		<hr />
		<Link to={this.props.backURL} > BACK </Link>
		<hr />
		<div dangerouslySetInnerHTML={note.body}></div>
	</div>
		);
	}

}

module.exports = GithubNoteFull;