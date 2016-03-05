import React from 'react';
import { Link } from "react-router";
import BookMarkIt from './BookMarkIt';
import Search from './Search';
import VerseSelector from './VerseSelector';

class Navigation extends React.Component {
  
    constructor(props) {
		super(props);		
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
					<Link to={this.props.chapter.previous[1]} onClick={this.props.getPrevious} className="btn btn-default" style={styles.previous}>
						<span className="glyphicon glyphicon-chevron-left"></span>
					</Link>

					<Search term={this.props.search} changeHandler={this.props.searchChangeHandler} submitHandler={this.props.bibleSearchSubmitHandler}/>

					<Link to={this.props.chapter.next[1]}  onClick={this.props.getNext}  className="btn btn-default" style={styles.next}>
						<span className="glyphicon glyphicon-chevron-right"></span>
					</Link>
							
					<VerseSelector getChapter={this.props.getChapter}/>
					
					<BookMarkIt />
					
				</div>
			</div>
		</div>
    )
  }
}

module.exports = Navigation;