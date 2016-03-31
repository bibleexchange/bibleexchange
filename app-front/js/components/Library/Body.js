import React from 'react';

class Body extends React.Component {
	
render() {

    return (
	<div className="container">	
		<h2>Body</h2>
	</div>
    );
  }
	
}

Body.propTypes = {
	allItems: React.PropTypes.object.isRequired
};

module.exports = Body;