import React from 'react';

import Navigation from '../components/Bible/Navigation';
import Reader from '../components/Bible/Reader';
import Feed from '../components/Bible/Feed';
import * as BibleChapterActions from '../actions/BibleChapterActions';
import BibleChapterStore from '../stores/BibleChapterStore';

class Bible extends React.Component {
	
    constructor(props) {
		super(props);	
		this.state = BibleChapterStore.getAll();		
	}
	
	componentWillMount(){
		BibleChapterStore.on("change", ()=>{
			this.setState(BibleChapterStore.getAll());
		});
	}
	
	addNextChapter(){		
		BibleChapterActions.addChapter(this.state.next[0]);
	}
	
	getNextChapter(){	
		BibleChapterActions.getChapter(this.state.next[0]);
	}
	
	getPreviousChapter(){		
		BibleChapterActions.getChapter(this.state.previous[0]);
	}

  render() {	
	
	const chapter = this.state;	
	
    return (
      <div>
		<Navigation chapter={chapter} getPrevious={this.getPreviousChapter.bind(this)} getNext={this.getNextChapter.bind(this)}/>
		<Reader chapter={chapter} addNextChapter={this.addNextChapter.bind(this)}/>
		<Feed />
      </div>
    )
  }
}

module.exports = Bible;