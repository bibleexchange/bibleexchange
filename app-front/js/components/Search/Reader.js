import React from 'react';
import { Link } from "react-router";
import SearchResultList from './SearchResultList';

class Reader extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	
    return (
		<div className="row">
			
			<div className="col-md-6 col-md-offset-3">		  
				  {this.props.results.map(function(r) {
						return <SearchResult key={Math.random()} {...r} />
					}, this)}
			<br />
			
			{this.props.pages.map(function(page) {
						return <Link to={page.url} className="btn btn-primary">{page.number}</Link>
					}, this)}
			
			
			</div>
		</div>
    )
  }
}

module.exports = Reader;