import React from 'react';
import { Link } from "react-router";

class SearchResult extends React.Component {
  
  constructor(props) {
	super(props);	
  }
 
  render() {
	
	const styles = {
		linkStyle:{border:'solid', background:'transparent',width:'100%'}
	};
	
	return (
		<Link to="" style={this.styles.linkStyle}>
			<strong>TITLE HERE</strong>
		</Link>
		)
  }
}

class SearchResultList extends React.Component {
  
    constructor(props) {
		super(props);	
	  }
  
  render() {
	var book = this.props.book;
	
	var chapters  = [];

	for (var i=1; i <= book.chapters; i++) {
		chapters.push(i);
	}
	
	const toggle = this.props.toggle;
	const getChapter = this.props.getChapter;
	
    return (
		<div>
			{chapters.map(function(chapter) {
			  return (
				<li className="square-list" key={chapter}>
					<Link to={"/bible/"+book.slug+"/"+chapter} id={chapter} onClick={toggle.bind(this)} onClick={getChapter.bind(this)}>
						{chapter}
					</Link>
				</li>
			 )})}
		</div>			

    )
  }
}

module.exports = SearchResultList;