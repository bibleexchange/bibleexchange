import React from 'react';
import { Link } from 'react-router';

class GithubNoteFull extends React.Component {
	
  render() { 
	let note = this.props.data;
	  
	return (
	<div>
		<hr />
			<div className="container">
				<Link to={this.props.backURL} > BACK </Link>
			</div>
		<hr />
		<div className="container">
			<div dangerouslySetInnerHTML={note.body}></div>
		</div>
	</div>
		);
	}

}

module.exports = GithubNoteFull;