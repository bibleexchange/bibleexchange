import React from 'react';
import { Link } from "react-router";
import BibleChapter from './BibleChapter';

class Reader extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	
	var chapter = this.props.chapter;
	
	const BibleChapterComponents = chapter.chapters.map((chapter)=>{
		return <BibleChapter key={Math.random()} {...chapter} />;
	});

    return (
		<div className="row">
			
			<div className="col-md-6 col-md-offset-3">
			{BibleChapterComponents}
			<br />
			<Link to={chapter.next.URL} onClick={this.props.addNextChapter} className="btn btn-success">next</Link>
			
			</div>
		</div>
    )
  }
}

module.exports = Reader;