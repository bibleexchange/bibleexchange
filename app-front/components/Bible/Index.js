import React from 'react';
import { browserHistory, Link } from "react-router";
import Navigation from './Navigation';
import BibleActionCreators from '../../actions/BibleActionCreators';
import BibleStore from '../../stores/BibleStore';
import BibleChapterStore from '../../stores/BibleChapterStore';
import SearchStore from '../../stores/SearchStore';
import { getRandomBibleChapter } from '../../util/MyHelpers';

class BibleIndex extends React.Component {

	componentWillMount(){

		if(BibleChapterStore.url !== null){
			browserHistory.push(BibleChapterStore.url);
		}else{		
			if(!this.props.params.chapter && !this.props.params.verse){
				var bookId = getRandomBibleChapter();
				BibleActionCreators.getChapter(bookId);
			}
		}
		this.state = this._getState();		
	}
	
	_getState() {
		return {
			books: BibleStore.books,
			chapters: BibleChapterStore.getAll(),
			search: SearchStore.getAll()
		};
	}

	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		BibleStore.addChangeListener(this.changeListener);
		BibleChapterStore.addChangeListener(this.changeListener);
		SearchStore.addChangeListener(this.changeListener);		    
	}
	
	_onChange(){		
		let newState = this._getState();
		this.setState(newState);	

		if(!this.props.params.book && newState.chapters.url){browserHistory.push(newState.chapters.url);}		
	}
	
	componentWillUnmount(){
		BibleStore.removeChangeListener(this._onChange);
		BibleChapterStore.removeChangeListener(this._onChange);
		SearchStore.removeChangeListener(this._onChange);
	}
	
  render() {
	
	return (
      <div>			
		<Navigation chapter={this.state.chapters} search={this.state.search.term} books={this.state.books} />
		 
		{this.props.children}
		 
      </div>
    )
  }
	
}

module.exports = BibleIndex;