import React from 'react';

class Reader extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	  
	var user = this.props.user;

    return (
		<div>
			Bible Reader
		</div>			

    )
  }
}

module.exports = Reader;