import React from 'react';
import { browserHistory, Link } from "react-router";

import ActionCreators from '../../actions/UserLibraryActionCreators';
import Footer from './Footer';
import LibraryStore from '../../stores/LibraryStore';
import SessionStore from '../../stores/SessionStore';

class LibraryIndex extends React.Component {

	componentWillMount(){
		this.state = this._getState();
	}
	
	_getState() {
		return {};
	}
 
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		LibraryStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		LibraryStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(newProps){
		console.log(newProps);
	}
	
  render() {
		
    return (
      <div>
			<div className="container">
				{this.props.children}
				<Footer data={this.state.data} />
			</div>
      </div>
    )
  }
	
}

module.exports = LibraryIndex;