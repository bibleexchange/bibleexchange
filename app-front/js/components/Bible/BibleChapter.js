import React from 'react';
import BibleVerse from './BibleVerse';

class BibleChapter extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	const BibleVerseComponents = this.props.verses.map((verse)=>{
		return <BibleVerse key={verse.id} {...verse} />;
	});
	
    return (
		<div id="bible">
			<h2>{this.props.book.n} {this.props.orderBy}</h2>
			{BibleVerseComponents}
		</div>			

    )
  }
}

module.exports = BibleChapter;