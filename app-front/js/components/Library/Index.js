import React from 'react';
import { browserHistory, Link } from "react-router";

import ActionCreators from '../../actions/LibraryActionCreators';
import Footer from './Footer';
import Body from './Body';
import Store from '../../stores/LibraryStore';
import SessionStore from '../../stores/SessionStore';

class LibraryIndex extends React.Component {

	componentWillMount(){
		this.state = this._getState();
	}
	
	_getState() {
		return {
			data:Store.getAll(),
			user: SessionStore.getAll()
		};
	}
 
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		Store.addChangeListener(this.changeListener);
		SessionStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		Store.removeChangeListener(this.changeListener);
		SessionStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(newProps){
		console.log(newProps);
	}
	
  render() {
		
    return (
      <div>
			
			<div className="container">
				<Header data={this.state.data} user={this.state.user}/>
				<Body data={this.state.data} />
				<Footer data={this.state.data} />
			</div>
      </div>
    )
  }
	
}

module.exports = LibraryIndex;