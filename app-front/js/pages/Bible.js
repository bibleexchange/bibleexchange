import React from 'react';

import Navigation from '../components/Bible/Navigation';
import Reader from '../components/Bible/Reader';
import Feed from '../components/Bible/Feed';

class Bible extends React.Component {
	
    constructor(props) {
		super(props);		
	}
	
  render() {	
	
	const chapter = this.props.route.data;
	
    return (
      <div>
		<Navigation chapter={chapter}/>
		<Reader />
		<Feed />
      </div>
    )
  }
}

module.exports = Bible;