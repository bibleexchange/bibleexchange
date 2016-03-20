import React from 'react';
import BibleVerseActionCreators from '../../actions/BibleVerseActionCreators';
import BibleChapterStore from '../../stores/BibleVerseStore';
import BibleVerseStore from '../../stores/BibleVerseStore';
import BibleVerseComponent from '../Partials/Bible/BibleVerse';

import { Link } from "react-router";

String.prototype.ucfirst = function()
{
	return this.charAt(0).toUpperCase() + this.substr(1);
}

class BibleVerse extends React.Component {

    constructor(props) {
		super(props);
		BibleVerseActionCreators.getVerseByReference(this.props.params.book,this.props.params.chapter,this.props.params.verse);
		this.state = this._getState();
		
		console.log("BibleVerse loaded");
	}
	
	_getState() {		
		return { 
			book:this.props.params.book,
			chapter:this.props.params.chapter,
			verse_number:this.props.params.verse,
			verse: BibleVerseStore.getAll()
			};
	}
	
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		BibleChapterStore.addChangeListener(this.changeListener);		
		BibleVerseStore.addChangeListener(this.changeListener);		
	}
	
	_onChange(){		
		console.log('verse is getting changed');
		let verseState = this._getState();
		this.setState(verseState);
	}
	
	componentWillMount(){
		console.log("BibleVerse will mount");
	}
	
	componentWillUnmount(){
		console.log("BibleVerse will Unmount");
		BibleVerseStore.removeChangeListener(this._onChange);
	}
	
  render() {
	  console.log('highlight rendered');
    return (
      <div>
		<br />
		<br />
		<Link to={!this.state.verse.chapterURL ? "":this.state.verse.chapterURL} className="btn btn-success">
			{this.state.book.ucfirst()} {this.state.chapter}
		</Link>
		<br />
		<br />
		<BibleVerseComponent url={this.state.verse.url} id={this.state.verse.id} v={this.state.verse.v} t={this.state.verse.body} />
		
      </div>
    )
  }
}

module.exports = BibleVerse;