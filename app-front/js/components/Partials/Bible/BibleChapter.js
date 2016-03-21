import React from 'react';
import BibleVerseComponent from './BibleVerse';
import { Link } from "react-router";

class BibleChapter extends React.Component {
 
  render() {
	const BibleVerseComponents = this.props.verses.map((verse)=>{
		return <BibleVerseComponent key={verse.id} {...verse} />;
	});
	
    return (
		<div id="bible">
			<h2 id={"ch_"+this.props.id}><Link to={!this.props.url ? "":this.props.url+"#ch_"+this.props.id} data={this.props} onClick={this.props.chapterClickHandler}>{this.props.book.n} {this.props.orderBy}</Link></h2>
			{BibleVerseComponents}
		</div>			

    )
  }
}

module.exports = BibleChapter;