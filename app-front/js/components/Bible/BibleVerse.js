import React from 'react';

class BibleVerse extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
    return (
		<p id={this.props.id} className="ui-widget-content">
			<a href={"#"+this.props.id} ><sup>{this.props.v}</sup> </a>
			{this.props.t}
		</p>			

    )
  }
}

module.exports = BibleVerse;