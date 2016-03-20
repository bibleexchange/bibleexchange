import React from 'react';
import BibleVerseComponent from './BibleVerse';
import { Link } from "react-router";

class BibleVerseFocus extends React.Component {
  
  render() {
	  
	let verse = this.props.data;
	
    return (
		<div id="verse-focus">
			<BibleVerseComponent url={verse.url} id={verse.id} v={verse.v} t={verse.body} />
		</div>			

    )
  }
}

module.exports = BibleVerseFocus;