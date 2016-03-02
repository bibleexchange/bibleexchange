import React from 'react';
import { browserHistory } from "react-router";

import Navigation from '../components/Bible/Navigation';
import Reader from '../components/Bible/Reader';
import Feed from '../components/Bible/Feed';
import * as BibleChapterActions from '../actions/BibleChapterActions';
import BibleChapterStore from '../stores/BibleChapterStore';

class Bible extends React.Component {
	
    constructor(props) {
		super(props);
	}
	
	componentWillMount(){
		
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
		
		BibleChapterStore.on("change", ()=>{
			this.state = BibleChapterStore.getAll();
			browserHistory.push(this.state.url);
		});
		
		BibleChapterStore.emit("change");
	}
	
	addNextChapter(){
		BibleChapterActions.addChapter(this.state.next[0]);
	}
	
	getNextChapter(event){	
		BibleChapterActions.getChapter(this.state.next[0]);
	}
	
	getChapter(){	
		BibleChapterActions.getChapter(this.id);
	}
	
	getPreviousChapter(){		
		BibleChapterActions.getChapter(this.state.previous[0]);
	}
	
  render() {	
	
	const chapter = this.state;	
	
    return (
      <div>
		<Navigation chapter={chapter} getPrevious={this.getPreviousChapter.bind(this)} getNext={this.getNextChapter.bind(this)} getChapter={this.getChapter}/>
		<Reader chapter={chapter} addNextChapter={this.addNextChapter.bind(this)}/>
		<Feed />
      </div>
    )
  }
}

module.exports = Bible;