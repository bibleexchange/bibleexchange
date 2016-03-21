import React from 'react';
import Navigation from '../Partials/Search/Navigation';
import Reader from '../Partials/Search/Reader';
import SearchStore from '../../stores/SearchStore';

class Search extends React.Component {
	
	getNextPage(){
		
	}
	
	getPreviousPage(){		
		
	}
	
  render() {	
	
	const results = this.state;	
	
    return (
      <div>
		<Navigation results={results} getPreviousPage={this.getPreviousPage.bind(this)} getNext={this.getNextPage.bind(this)} />
		<Reader results={results} />
      </div>
    )
  }
}

module.exports = Search;