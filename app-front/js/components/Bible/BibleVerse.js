import React from 'react';

class BibleVerse extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
    return (
		<p className="ui-widget-content">
			<sup>{this.props.v}</sup> {this.props.t}
		</p>			

    )
  }
}

module.exports = BibleVerse;