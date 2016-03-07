import React from 'react';
import { browserHistory } from "react-router";

import Navigation from '../components/Bible/Navigation';
import Reader from '../components/Bible/Reader';
import Feed from '../components/Bible/Feed';
import * as BibleChapterActions from '../actions/BibleChapterActions';
import * as BibleVerseActions from '../actions/BibleVerseActions';
import * as SearchActions from '../actions/SearchActions';
import BibleChapterStore from '../stores/BibleChapterStore';
import SearchStore from '../stores/SearchStore';
import BibleVerseStore from '../stores/BibleVerseStore';

class Bible extends React.Component {
	
    constructor(props) {
		super(props);
		this.state = {
			chapters: BibleChapterStore.getAll(),
			search: SearchStore.getAll(),
			message: BibleChapterStore.getMessage(),
			verse: BibleVerseStore.getAll()
		};
		
	}
	
	_onChange(){
		console.log("bible related data changed so updating Bible.state...");
		this.setState({
			chapters: BibleChapterStore.getAll(),
			search: SearchStore.getAll(),
			message: BibleChapterStore.getMessage(),
			verse: BibleVerseStore.getAll()
		});		
		
		console.log("LINE 73, BIBLE.js: " + this.state.search.url);
		browserHistory.push(this.state.search.url);	
		
	}
	
	componentWillMount(){
		console.log("Bible will mount");
	}
	
	componentDidMount(){
		console.log("Bible Did Mount");	
		
		SearchStore.addChangeListener(this._onChange.bind(this));
		BibleChapterStore.addChangeListener(this._onChange.bind(this));
		BibleVerseStore.addChangeListener(this._onChange.bind(this));
		
		if( ! this.props.params.book){
			console.log('book parameter not given');
			var store = BibleChapterStore.getAll();
			if( store.id == false){
				console.log('Store empty so used default settings.');
				var reference = store.reference;
				var url = store.url;
			}else{
				console.log('grabbed chapter info from store.');
				var reference = store.reference;
				var url = store.url;
			}
			
			console.log('Redirected to valid url.');
			
		}else if(this.props.params.verse){
			var reference = this.props.params.book + " " + this.props.params.chapter + ":"+ this.props.params.verse;
			
			BibleVerseActions.getVerseByReference(reference);
			
		}else{
			var reference = this.props.params.book + " " + this.props.params.chapter;
		}
		
		BibleChapterActions.getChapterByReference(reference);	
	
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		BibleChapterStore.removeChangeListener(this._onChange);
		SearchStore.removeChangeListener(this._onChange);
		BibleVerseStore.removeChangeListener(this._onChange);
	}
	
	addNextChapter(){
		BibleChapterActions.addChapter(this.state.chapters.next[0]);
	}
	
	getNextChapter(){	
		BibleChapterActions.getChapter(this.state.chapters.next[0]);
	}
	
	getChapter(){	
		BibleChapterActions.getChapter(this.id);
	}
	
	getPreviousChapter(){		
		BibleChapterActions.getChapter(this.state.chapters.previous[0]);
	}
	
	searchChangeHandler(event) {
		SearchActions.updateSearch(event.target.value);
	  }
	
	chapterClickHandler(event) {
		window.scrollTo(0, 0);
		BibleChapterActions.keepOnlyThisChapter(this.data);
	}
	
	bibleSearchSubmitHandler(event) {
		event.preventDefault();
		BibleChapterActions.getChapterByReference(this.state.search.term);	
	}
	
	getMessage(){
		if(this.state.message){		
			return {
				__html: '<p>'+this.state.message + 'Want to search Bible exchange for <a href="/search/'+this.state.search.term+'" > "' + this.state.search.term + '"</a> instead?</p>'
			};
		}
	}
	
  render() {
	
    return (
      <div>
		<Navigation chapter={this.state.chapters} getPrevious={this.getPreviousChapter.bind(this)} getNext={this.getNextChapter.bind(this)} getChapter={this.getChapter} search={this.state.search.term} searchChangeHandler={this.searchChangeHandler.bind(this)} bibleSearchSubmitHandler={this.bibleSearchSubmitHandler.bind(this)}/>
		
		<div dangerouslySetInnerHTML={this.getMessage()} />
		
		<Reader chapter={this.state.chapters} addNextChapter={this.addNextChapter.bind(this)} chapterClickHandler={this.chapterClickHandler}/>
		<Feed />
      </div>
    )
  }
}

module.exports = Bible;