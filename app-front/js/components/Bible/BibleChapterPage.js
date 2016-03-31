import React from 'react';
import { browserHistory, Link } from "react-router";
import Reader from './Reader';
import BibleActionCreators from '../../actions/BibleActionCreators';
import BibleStore from '../../stores/BibleChapterStore';
import BibleChapterStore from '../../stores/BibleChapterStore';

class BibleChapterPage extends React.Component {

	componentWillMount(){
		this.state = this._getState();
	}
	
	_getState() {
		return {
			chapters: BibleChapterStore.getAll()
		};
	}

	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		BibleChapterStore.addChangeListener(this.changeListener);
		BibleStore.addChangeListener(this.changeListener);
		//window.addEventListener('scroll', this.handleScroll.bind(this));
	}
	
	componentWillReceiveProps(newProps){
		BibleActionCreators.getChapterByReference(newProps.params.book, newProps.params.chapter);
	}
	
	_onChange(){		
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		BibleStore.removeChangeListener(this._onChange);
		BibleChapterStore.removeChangeListener(this._onChange);
		//window.removeEventListener('scroll', this.handleScroll);
	}

  render() {
	
    return (
      <div>
		<Reader chapters={this.state.chapters} addNextChapter={this.addNextChapter.bind(this)} chapterClickHandler={this.chapterClickHandler} />;
      </div>
    )
  }

	addNextChapter(event){
		event.preventDefault();
		let chapter_id = this.state.chapters.next[0];
		let url = this.state.chapters.next[1];
		
		BibleActionCreators.addChapter(this.state.chapters.next[0]);
		browserHistory.push(url);
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
			browserHistory.push(url);
		  }
	}
	
	chapterClickHandler(event) {
		window.scrollTo(0, 0);
		console.log(this.data);
		BibleActionCreators.keepOnlyThisChapter(this.data);
	}
	
}

module.exports = BibleChapterPage;