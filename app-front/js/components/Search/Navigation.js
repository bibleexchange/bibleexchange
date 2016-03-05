import React from 'react';
import { Link } from "react-router";
import Search from '../Bible/Search';

class Navigation extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	  
	const chapter = this.props.chapter;
	
	const styles = {
		btn:{border:'none', background:'transparent'},
		next:{border:'none', background:'transparent'},
		previous:{border:'none', background:'transparent'}
	};
	
    return (	
		<div className="row blueBG" style={{marginBottom:'25p', textAlign:'center'}}>
			<div className="container">
				<div className="col-xs-12">	
					<Link onClick={this.props.getPrevious} className="btn btn-default" style={styles.previous}>
						<span className="glyphicon glyphicon-chevron-left"></span>
					</Link>

					<Search term={chapter.reference} />

					<Link onClick={this.props.getNext}  className="btn btn-default" style={styles.next}>
						<span className="glyphicon glyphicon-chevron-right"></span>
					</Link>
					
				</div>
			</div>
		</div>
    )
  }
}

module.exports = Navigation;