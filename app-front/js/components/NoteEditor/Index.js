import React from 'react';
import { browserHistory, Link } from "react-router";
import NoteStore from '../../stores/NoteStore';
import NoteEditor from './NoteEditor';
import NoteActionCreators from '../../actions/NoteActionCreators';

class NoteEditorIndex extends React.Component {

	componentWillMount(){
		this.state = this._getState();
	}
	
	_getState() {
		return {
			data:NoteStore.getAll()
		};
	}
 
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		NoteStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){	
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		NoteStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(newProps){
		NoteActionCreators.find(newProps.note);
	}
	
  render() {
	
    return (
			<div className="container">
				<NoteEditor note={this.state.data} />
				<Footer allItems={this.state.data} />
			</div>
    )
  }
	
}

module.exports = NoteEditorIndex;