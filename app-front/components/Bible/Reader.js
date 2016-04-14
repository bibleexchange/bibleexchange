import React from 'react';
import { Link } from "react-router";
import Loading from 'react-loading';
import BibleChapter from './BibleChapter';
import BibleChapterStore from '../../stores/BibleChapterStore';

class Reader extends React.Component {

	componentWillMount(){	
		this.state = this._getState();
	}
	
	_getState() {
		return {
			loading: BibleChapterStore.fetching
		};
	}
	
	_onChange(){		
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		BibleChapterStore.addChangeListener(this.changeListener);
	}

	componentWillUnmount(){
		BibleChapterStore.removeChangeListener(this._onChange);
	}
	
  render() {
	return (
		<div className="row">
			
			<div className="col-md-6 col-md-offset-3">		  
				  {this.props.chapters.chapters.map(function(ch) {
						return (<BibleChapter chapterClickHandler={this.props.chapterClickHandler} key={Math.random()} {...ch} />);
					}, this)}
			
			<hr />
			{this.state.loading ? <Loading type='bars' color='#e3e3e3' /> : <Link to={!this.props.chapters.next[1] ? "":this.props.chapters.next[1]}  onClick={this.clickHandler.bind(this)}  className="btn btn-success">+</Link>}
			<hr />
			
			</div>
		</div>
    )
  }
  
  clickHandler(event){
	  this.props.addNextChapter(event);
  }
  
}

module.exports = Reader;
