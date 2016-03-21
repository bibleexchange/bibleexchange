import React from 'react';
import { browserHistory, Link } from "react-router";

import GoHomeComponent from '../Partials/GoHome';
import Navigation from '../Partials/Bible/Navigation';
import Reader from '../Partials/Bible/Reader';
import BibleVerseFocus from '../Partials/Bible/BibleVerseFocus';

import BibleActionCreators from '../../actions/BibleActionCreators';
import SearchActionCreators from '../../actions/SearchActionCreators';

import BibleStore from '../../stores/BibleStore';
import BibleChapterStore from '../../stores/BibleChapterStore';
import BibleVerseStore from '../../stores/BibleVerseStore';
import SearchStore from '../../stores/SearchStore';

class Bible extends React.Component {

	componentWillMount(){
		console.log("Bible will mount");
		
		if(this.props.params.verse){
			BibleActionCreators.getVerseByReference(this.props.params.book, this.props.params.chapter, this.props.params.verse);
		}else{
			BibleActionCreators.emptyVerse();
			BibleActionCreators.getChapterByReference(this.props.params.book, this.props.params.chapter);
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
			verse: BibleVerseStore.getAll(),
			scrollChapter: BibleChapterStore.id
		};
	}

	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		
		BibleStore.addChangeListener(this.changeListener);
		BibleChapterStore.addChangeListener(this.changeListener);
		BibleVerseStore.addChangeListener(this.changeListener);
		SearchStore.addChangeListener(this.changeListener);		
		window.addEventListener('scroll', this.handleScroll.bind(this));
	}
	
	_onChange(){		
		let bibleState = this._getBibleState();
		this.setState(bibleState);		
	}
	
	componentWillReceiveProps(newProps){
		
		if(newProps.params.verse){
			BibleActionCreators.getVerseByReference(newProps.params.book, newProps.params.chapter, newProps.params.verse);
		}else{
			BibleActionCreators.emptyVerse();
			BibleActionCreators.getChapterByReference(newProps.params.book, newProps.params.chapter);
		}
		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		BibleStore.removeChangeListener(this.changeListener);
		BibleChapterStore.removeChangeListener(this._onChange);
		BibleVerseStore.removeChangeListener(this._onChange);
		SearchStore.removeChangeListener(this._onChange);
		window.removeEventListener('scroll', this.handleScroll);
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
	
    return (
      <div>
			<div className="container">
				<GoHomeComponent />
			</div>
			
		<Navigation getPreviousHandler={this.getPreviousHandler.bind(this)} getNextHandler={this.getNextHandler.bind(this)} chapter={this.state.chapters} search={this.state.search.term} books={this.state.books} />
		
		<div dangerouslySetInnerHTML={this.getErrors()} />
		 
		 {(() => {

			switch (this.state.verse.id) {
			  case null:
				return <Reader chapters={this.state.chapters} addNextChapter={this.addNextChapter.bind(this)} chapterClickHandler={this.chapterClickHandler} />;
			  default:
				return <BibleVerseFocus data={this.state.verse} clickHandler={this.chapterReload}/>;
			}
		  })()}
		
      </div>
    )
  }

	getNextHandler(event) {
		event.preventDefault();
		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		BibleActionCreators.getChapter(chapter_id);
		browserHistory.push(url);
		console.log('navigated to: ', this.state.chapters.next);
	  }
	
	chapterReload(event) {
		event.preventDefault();
		browserHistory.push(this.data);
	  }
	
	getPreviousHandler(event) {
		event.preventDefault();
		let chapter_id = this.state.chapters.previous[0];
		let url = this.state.chapters.previous[1];
		
		BibleActionCreators.getChapter(chapter_id);
		
		browserHistory.push(url);
		console.log('navigated to: ', this.state.chapters.previous);
	  }
	
	addNextChapter(event){
		event.preventDefault();
		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		BibleActionCreators.addChapter(this.state.chapters.next[0]);
		browserHistory.push(url);
	}

	chapterClickHandler(event) {
		window.scrollTo(0, 0);
		console.log(this.data);
		BibleActionCreators.keepOnlyThisChapter(this.data);
	}
	
	handleScroll(event) {
		let w = event.srcElement.body;
		var inHeight = window.innerHeight;
		var totalScrolled = w.scrollTop+inHeight;

		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		console.log({totalScrolled: totalScrolled, scrollTop: w.scrollTop+900});
		
		if(w.scrollTop+900 > totalScrolled && this.state.scrollChapter !== chapter_id){  //user reached bottom 
			
			BibleActionCreators.addChapter(this.state.chapters.next[0]);
			this.setState({scrollChapter:chapter_id});
			//browserHistory.push(url);
		  }
	}
	
}

module.exports = Bible;