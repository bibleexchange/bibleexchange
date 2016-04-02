import React from 'react';
import { Link } from "react-router";
import Search from './Search';
import VerseSelector from './VerseSelector';
import BibleActionCreators from '../../actions/BibleActionCreators';
import SearchActionCreators from '../../actions/SearchActionCreators';
import SearchStore from '../../stores/SearchStore';

class Navigation extends React.Component {

    constructor(props) {
		super(props);
		this.state = this._getNavState();		
	  }
 	
	_getNavState() {		
		return {
			search: SearchStore.getAll()
		};
	}
	
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);
		SearchStore.addChangeListener(this.changeListener);		
	}
	
	_onChange(){		
		let navState = this._getNavState();
		this.setState(navState);
	}
	
  render() {
	const styles = {
		btn:{border:'none', background:'transparent'},
		next:{border:'none', background:'transparent'},
		previous:{border:'none', background:'transparent'}
	};

    return (	
		<div className="row blueBG" style={{marginBottom:'25p', textAlign:'center'}}>
			<div className="container">
				<div className="col-xs-12">	
					<Link to={!this.props.chapter.previous[1] ? "":this.props.chapter.previous[1]} className="btn btn-default" style={styles.previous}>
						<span className="glyphicon glyphicon-chevron-left"></span>
					</Link>

					<Search term={this.props.search} changeHandler={this.searchChangeHandler} submitHandler={this.bibleSearchSubmitHandler.bind(this)}/>

					<Link to={!this.props.chapter.next[1] ? "":this.props.chapter.next[1]}  className="btn btn-default" style={styles.next} onClick={this.props.getNextHandler}>
						<span className="glyphicon glyphicon-chevron-right"></span>
					</Link>
							
					<VerseSelector books={this.props.books}/>
					
				</div>
			</div>
		</div>
    )
  }
  
	searchChangeHandler(event) {
		SearchActionCreators.updateSearch(event.target.value);
	  }
	
	bibleSearchSubmitHandler(event) {
		event.preventDefault();
		console.log('search submitted...');
		this.setState({redirect:true});
		BibleActionCreators.getChapterByReference(this.state.search.term);
	}
	
}

module.exports = Navigation;