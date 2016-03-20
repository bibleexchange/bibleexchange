import React from 'react';

class BibleBook extends React.Component {

    constructor(props) {
		super(props);				
		console.log("BibleBook loaded");
	}
	
  render() {
	
    return (
      <div>	
		<h1>{this.props.params.book}</h1>

      </div>
    )
  }
}

module.exports = BibleBook;