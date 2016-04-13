import React from 'react';
import { Link } from 'react-router';

class BibleVerseComponent extends React.Component {
 
  render() {
    return (
		<div>
			<Link to={!this.props.url ? "":this.props.url} style={{color:"black"}}>
				<p id={this.props.id} className="ui-widget-content">
					<sup>{this.props.v}</sup>
					{this.props.t}
				</p>			
			</Link>
		</div>
    )
  }
}

module.exports = BibleVerseComponent;