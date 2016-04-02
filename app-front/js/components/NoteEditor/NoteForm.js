import React from 'react';
import classNames from 'classNames';
import NoteTextInput from '../TextInput';

class NoteForm extends React.Component {
	
	componentWillMount(){	
		this.state = this._getState();
	}
	
	_getState() {
		return {
			show:false
		};
	}

  render() {
	
	let noteFormStyle = {display:"none"};
	
	if(this.state.show){
		noteFormStyle = {display:"block"};
		}
		
  return (
	<div>
		<button className="btn btn-small btn-default" onClick={this.toggle.bind(this)}>Make a Note Here</button>
		
		<form style={noteFormStyle}>
		   <input type="text" />
		</form>
	</div>
    );
  }

  toggle() {
    const show = !this.state.show;
    this.setState({show:show});
  }
  
}

module.exports = NoteForm;