import React from 'react';
import { Link } from 'react-router';

class GoHome extends React.Component {	
  render() {
    return (
          <div className="navbar-header">
			<Link to="/" className="navbar-brand">Back</Link>
          </div>
	)
  }
}

module.exports = GoHome;