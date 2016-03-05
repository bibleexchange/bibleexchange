import React from 'react';
import BibleVerse from './BibleVerse';
import { Link } from "react-router";
import * as BibleChapterActions from '../../actions/BibleChapterActions';

class BibleChapter extends React.Component {
  
    constructor(props) {
		super(props);
		console.log(props.url);
	  }
  
  render() {
	const BibleVerseComponents = this.props.verses.map((verse)=>{
		return <BibleVerse key={verse.id} {...verse} />;
	});
	
    return (
		<div id="bible">
			<h2 id={"ch_"+this.props.id}><Link to={this.props.url+"#ch_"+this.props.id} data={this.props} onClick={this.props.chapterClickHandler}>{this.props.book.n} {this.props.orderBy}</Link></h2>
			{BibleVerseComponents}
		</div>			

    )
  }
}

module.exports = BibleChapter;