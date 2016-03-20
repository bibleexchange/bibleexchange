import React from 'react';

class Feed extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	  
	var user = this.props.user;

    return (
		<div>
			Bible Feed
		</div>			

    )
  }
}

module.exports = Feed;