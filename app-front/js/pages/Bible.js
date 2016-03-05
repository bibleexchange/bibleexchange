import React from 'react';
import { browserHistory } from "react-router";

import Navigation from '../components/Bible/Navigation';
import Reader from '../components/Bible/Reader';
import Feed from '../components/Bible/Feed';
import * as BibleChapterActions from '../actions/BibleChapterActions';
import * as SearchActions from '../actions/SearchActions';
import BibleChapterStore from '../stores/BibleChapterStore';
import SearchStore from '../stores/SearchStore';

class Bible extends React.Component {
	
    constructor(props) {
		super(props);
		this.state = {
			chapters: BibleChapterStore.getAll(),
			search: SearchStore.getTerm(),
			message: BibleChapterStore.getMessage()
		};
		
	}
	
	_onChange(){
		console.log("bible related data changed so updating Bible.state...");
		this.setState({
			chapters: BibleChapterStore.getAll(),
			search: SearchStore.getTerm(),
			message: BibleChapterStore.getMessage()
		});		
	}
	
	componentWillMount(){
		console.log("Bible will mount");
	}
	
	componentDidMount(){
		console.log("Bible Did Mount");	
		
		BibleChapterStore.addChangeListener(this._onChange.bind(this));
		SearchStore.addChangeListener(this._onChange.bind(this));
		
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
			browserHistory.push(url);
		}else{
			var reference = this.props.params.book + " " + this.props.params.chapter;
		}
		
		BibleChapterActions.getChapterByReference(reference);		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		BibleChapterStore.removeChangeListener(this._onChange);
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
		BibleChapterActions.getChapterByReference(this.state.search);	
		
	}
	
	getMessage(){
		if(this.state.message){		
			return {
				__html: '<p>'+this.state.message + 'Want to search Bible exchange for <a href="/search/'+this.state.search+'" > "' + this.state.search + '"</a> instead?</p>'
			};
		}
	}
	
  render() {
	
    return (
      <div>
		<Navigation chapter={this.state.chapters} getPrevious={this.getPreviousChapter.bind(this)} getNext={this.getNextChapter.bind(this)} getChapter={this.getChapter} search={this.state.search} searchChangeHandler={this.searchChangeHandler.bind(this)} bibleSearchSubmitHandler={this.bibleSearchSubmitHandler.bind(this)}/>
		
		<div dangerouslySetInnerHTML={this.getMessage()} />
		
		<Reader chapter={this.state.chapters} addNextChapter={this.addNextChapter.bind(this)} chapterClickHandler={this.chapterClickHandler}/>
		<Feed />
      </div>
    )
  }
}

module.exports = Bible;