import React from 'react';
import Card from './StudyCard';

class DirectoryOfStudies extends React.Component {
	
	constructor(props) {
		super(props);
	}
	
  render() {
    return (
      <div>
		<h1>Directory</h1>
		
		<Card />
		
      </div>
    )
  }
}

module.exports = DirectoryOfStudies;