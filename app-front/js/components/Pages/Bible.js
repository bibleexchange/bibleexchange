import React from 'react';
import { browserHistory, Link } from "react-router";

import GoHomeComponent from '../Partials/GoHome';
import Navigation from '../Partials/Bible/Navigation';
import Reader from '../Partials/Bible/Reader';
import BibleVerseFocus from '../Partials/Bible/BibleVerseFocus';

import BibleChapterActionCreators from '../../actions/BibleChapterActionCreators';
import BibleVerseActionCreators from '../../actions/BibleVerseActionCreators';
import SearchActionCreators from '../../actions/SearchActionCreators';

import BibleStore from '../../stores/BibleStore';
import BibleChapterStore from '../../stores/BibleChapterStore';
import BibleVerseStore from '../../stores/BibleVerseStore';
import SearchStore from '../../stores/SearchStore';

class Bible extends React.Component {

	componentWillMount(){
		console.log("Bible will mount");
		BibleChapterActionCreators.getChapterByReference(this.props.params.book, this.props.params.chapter);
		
		if(this.props.params.verse){
			BibleVerseActionCreators.getVerseByReference(this.props.params.book, this.props.params.chapter, this.props.params.verse);
		}
		
		this.state = this._getBibleState();
	}
	
	_getBibleState() {
		return {
			book:this.props.params.book,
			chapter:this.props.params.chapter,
			v:this.props.params.verse,
			books: BibleStore.books,
			chapters: BibleChapterStore.getAll(),
			search: SearchStore.getAll(),
			errors: BibleChapterStore.errors,
			verse: BibleVerseStore.getAll()
		};
	}
	
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		
		BibleStore.addChangeListener(this.changeListener);
		BibleChapterStore.addChangeListener(this.changeListener);
		BibleVerseStore.addChangeListener(this.changeListener);
		SearchStore.addChangeListener(this.changeListener);		
	}
	
	_onChange(){		
		let bibleState = this._getBibleState();
		this.setState(bibleState);		
	}
	
	componentWillReceiveProps(newProps){
		BibleChapterActionCreators.getChapterByReference(newProps.params.book, newProps.params.chapter);
		
		if(newProps.params.verse){
			BibleVerseActionCreators.getVerseByReference(newProps.params.book, newProps.params.chapter, newProps.params.verse);
		}
		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		BibleStore.removeChangeListener(this.changeListener);
		BibleChapterStore.removeChangeListener(this._onChange);
		BibleVerseStore.removeChangeListener(this._onChange);
		SearchStore.removeChangeListener(this._onChange);
	}
	
	getErrors(){
		if(this.state.errors.count >= 1){	
			
			console.log(this.state.errors);
		
			return {
				__html: '<p>'+this.state.errors + 'Want to search Bible exchange for <a href="/search/'+this.state.search.term+'" > "' + this.state.search.term + '"</a> instead?</p>'
			};
		}
	}
	
  render() {
console.log(this.state.verse);
    return (
      <div>
			<div className="container">
				<GoHomeComponent />
			</div>
			
		<Navigation getPreviousHandler={this.getPreviousHandler.bind(this)} getNextHandler={this.getNextHandler.bind(this)} chapter={this.state.chapters} search={this.state.search.term} books={this.state.books} />
		
		<div dangerouslySetInnerHTML={this.getErrors()} />
		
		<BibleVerseFocus data={this.state.verse} />
		
		<Reader chapters={this.state.chapters} addNextChapter={this.addNextChapter.bind(this)} chapterClickHandler={this.chapterClickHandler} />
		
      </div>
    )
  }
  
	getNextHandler(event) {
		event.preventDefault();
		
		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		BibleChapterActionCreators.getChapter(chapter_id);
		browserHistory.push(url);
		console.log('navigated to: ', this.state.chapters.next);
	  }
	
	getPreviousHandler(event) {
		event.preventDefault();
		
		let chapter_id = this.state.chapters.previous[0];
		let url = this.state.chapters.previous[1];
		
		BibleChapterActionCreators.getChapter(chapter_id);
		
		browserHistory.push(url);
		console.log('navigated to: ', this.state.chapters.previous);
	  }
	
	addNextChapter(event){
		event.preventDefault();
		
		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		BibleChapterActionCreators.addChapter(this.state.chapters.next[0]);
		//browserHistory.push(url);
	}

	chapterClickHandler(event) {
		window.scrollTo(0, 0);
		console.log(this.data);
		BibleChapterActionCreators.keepOnlyThisChapter(this.data);
	}
	
}

module.exports = Bible;