import React from 'react';
import { browserHistory, Link } from "react-router";

import GoHomeComponent from '../Partials/GoHome';
import Navigation from '../Partials/Bible/Navigation';

import BibleChapterActionCreators from '../../actions/BibleChapterActionCreators';
import SearchActionCreators from '../../actions/SearchActionCreators';

import BibleStore from '../../stores/BibleStore';
import BibleChapterStore from '../../stores/BibleChapterStore';
import SearchStore from '../../stores/SearchStore';

class Bible extends React.Component {

    constructor(props) {
		super(props);		
		this.state = this._getBibleState();
	} 
	
	componentWillMount(){
		console.log("Bible will mount");
		BibleChapterActionCreators.getChapterByReference(this.props.params.book, this.props.params.chapter)
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
			verse: BibleStore.verse
		};
	}
	
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		
		BibleStore.addChangeListener(this.changeListener);
		BibleChapterStore.addChangeListener(this.changeListener);
		SearchStore.addChangeListener(this.changeListener);		
	}
	
	_onChange(){		
		let bibleState = this._getBibleState();
		this.setState(bibleState);		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		BibleStore.removeChangeListener(this.changeListener);
		BibleChapterStore.removeChangeListener(this._onChange);
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
	/*
	let url = {
		book:this.state.book,
		chapter:this.state.chapter,
		verse:this.state.verse
	};
	*/
    return (
      <div>
			<div className="container">
				<GoHomeComponent />
				{this.props.params.chapter}
			</div>
			
		<Navigation getPreviousHandler={this.getPreviousHandler.bind(this)} getNextHandler={this.getNextHandler.bind(this)} chapter={this.state.chapters} search={this.state.search.term} books={this.state.books} />
		
		<div dangerouslySetInnerHTML={this.getErrors()} />
		
		{this.props.children}
		
      </div>
    )
  }
  
	getNextHandler(event) {
		event.preventDefault();
		
		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		BibleChapterActionCreators.getChapter(chapter_id);
		
		this.context.router.push(url);
		console.log('navigated to: ', this.state.chapters.next);
	  }
	
	getPreviousHandler(event) {
		event.preventDefault();
		
		let chapter_id = this.state.chapters.previous[0];
		let url = this.state.chapters.previous[1];
		
		BibleChapterActionCreators.getChapter(chapter_id);
		
		this.context.router.push(url);
		console.log('navigated to: ', this.state.chapters.previous);
	  }
	  
}

Bible.contextTypes = {
  router: React.PropTypes.object.isRequired
};

module.exports = Bible;