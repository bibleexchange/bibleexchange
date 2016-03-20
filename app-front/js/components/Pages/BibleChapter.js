import React from 'react';
import Reader from '../Partials/Bible/Reader';
import BibleChapterActionCreators from '../../actions/BibleChapterActionCreators';
import BibleChapterStore from '../../stores/BibleChapterStore';

class BibleChapter extends React.Component {

    constructor(props) {
		super(props);
		this.state = this._getState();	
		console.log("BibleChapter loaded");
	}
	
	componentWillMount(){
		console.log("BibleChapter will mount");
	}
	
	_getState() {
		return {
			chapters: BibleChapterStore.getAll()
		};
	}
	
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		BibleChapterStore.addChangeListener(this.changeListener);	
	}
	
	_onChange(){		
		let chapterState = this._getState();
		this.setState(chapterState);		
	}
	
	componentWillUnmount(){
		console.log("BibleChapter will Unmount");
		BibleChapterStore.removeChangeListener(this._onChange);
	}
	
  render() {
		
    return (
      <div>	
		
		{this.props.children}
		
		<Reader chapter={this.state.chapters} addNextChapter={this.addNextChapter} chapterClickHandler={this.chapterClickHandler}/>
      </div>
    )
  }
  
    addNextChapter(){
		BibleChapterActionCreators.addChapter(this.state.chapters.next[0]);
	}
	
	
	chapterClickHandler(event) {
		window.scrollTo(0, 0);
		BibleChapterActionCreators.keepOnlyThisChapter(this.data);
	}
  
}

module.exports = BibleChapter;