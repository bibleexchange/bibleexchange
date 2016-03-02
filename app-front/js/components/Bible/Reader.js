import React from 'react';
import { Link } from "react-router";
import BibleChapter from './BibleChapter';

class Reader extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {

    return (
		<div className="row">
			
			<div className="col-md-6 col-md-offset-3">		  
				  {this.props.chapter.chapters.map(function(ch) {
						return <BibleChapter key={Math.random()} {...ch} />
					}, this)}
			<br />
			
			<Link to={this.props.chapter.next[1]}  onClick={this.props.addNextChapter}  className="btn btn-success">+</Link>
			</div>
		</div>
    )
  }
}

module.exports = Reader;