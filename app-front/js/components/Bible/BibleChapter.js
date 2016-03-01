import React from 'react';
import BibleVerse from './BibleVerse';

class BibleChapter extends React.Component {
  
    constructor(props) {
		super(props);		
		console.log(props);
	  }
  
  render() {
	const BibleVerseComponents = this.props.verses.map((verse)=>{
		return <BibleVerse key={verse.id} {...verse} />;
	});
	
    return (
		<div id="bible">
			{BibleVerseComponents}
		</div>			

    )
  }
}

module.exports = BibleChapter;