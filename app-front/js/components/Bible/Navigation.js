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
	  
	var user = this.props.user;
	const p = this.props;
	const chapter = p.chapter;
	
	const styles = {
		btn:{border:'none', background:'transparent'},
		next:{border:'none', background:'transparent'},
		previous:{border:'none', background:'transparent'}
	};
	
    return (	
		<div className="row blueBG" style={{marginBottom:'25p', textAlign:'center'}}>
			<div className="container">
				<div className="col-xs-12">	
					<Link to={chapter.previousURL} className="btn btn-default" style={styles.previous}>
						<span className="glyphicon glyphicon-chevron-left"></span>
					</Link>

					<Search currentChapter={chapter} />

					<Link to={chapter.nextURL} className="btn btn-default" style={styles.next}>
						<span className="glyphicon glyphicon-chevron-right"></span>
					</Link>
							
					<VerseSelector />
					
					<BookMarkIt />
					
				</div>
			</div>
		</div>
    )
  }
}

module.exports = Navigation;