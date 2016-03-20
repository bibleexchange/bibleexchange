import React from 'react';
import Reader from '../Partials/Bible/Reader';

class BibleBook extends React.Component {

    constructor(props) {
		super(props);				
		console.log("BibleBook loaded");
	}
	
  render() {
	
    return (
      <div>	
		{this.props.children}
      </div>
    )
  }
}

module.exports = BibleBook;