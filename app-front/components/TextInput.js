import React from 'react';
import AppConstants from '../util/AppConstants';

class TextInput extends React.Component {

	componentWillMount(){	
		this.state = this._getState();
	}
	
  render() {
	  
	let inputStyle = {width:"100%"};
	  
    return (
      <textarea
		style={inputStyle}
        id={this.props.id}
        placeholder={this.props.placeholder}
        onBlur={this._save.bind(this)}
        onChange={this._onChange.bind(this)}
        onKeyDown={this._onKeyDown.bind(this)}
        value={this.state.value}
        autoFocus={true}
      />
    );
  }

   _getState() {
    return {
      value: this.props.value || ''
    };
  }
  
  _save() {
    this.props.onSave(this.state.value);
    this.setState({
      value: ''
    });
  }

  _onChange(event) {
	let newState = {
		  value: event.target.value
		};
	this.setState(newState);
  }

  _onKeyDown(event) {
    if (event.keyCode === AppConstants.ENTER_KEY_CODE) {
      this._save(); 
    }
  }

}

TextInput.propTypes = { 
	id: React.PropTypes.string,
    placeholder: React.PropTypes.string,
    onSave: React.PropTypes.func.isRequired,
    value: React.PropTypes.string
	};

module.exports = TextInput;