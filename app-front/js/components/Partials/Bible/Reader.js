import React from 'react';
import { Link } from "react-router";
import BibleChapter from './BibleChapter';

class Reader extends React.Component {
  
  render() {

    return (
		<div className="row">
			
			<div className="col-md-6 col-md-offset-3">		  
				  {this.props.chapters.chapters.map(function(ch) {
						return <BibleChapter chapterClickHandler={this.props.chapterClickHandler} key={Math.random()} {...ch} />
					}, this)}
			<br />
			
			<Link to={!this.props.chapters.next[1] ? "":this.props.chapters.next[1]}  onClick={this.props.addNextChapter}  className="btn btn-success">+</Link>
			</div>
		</div>
    )
  }
}

module.exports = Reader;