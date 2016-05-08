import React from 'react';
import classNames from 'classnames';
import NoteTextInput from '../TextInput';

class NoteEditor extends React.Component {

	componentWillMount(){	
		this.state = this._getState();
	}
	
	_getState() {
		return {
			isEditing:false
		};
	}

  render() {
    var note = this.props.note;

    var input;
    if (this.state.isEditing) {
      input =
        <NoteTextInput
          className="edit"
          onSave={this._onSave.bind(this)}
          value={note.title}
        />;
    }

    return (
      <div
        className={classNames({
          'editing': this.state.isEditing
        })}
        key={note.id}
		style={{width:"100%", border:"solid 1px gray",listStyleType:"none", margin:"10px", padding:"10px",marginLeft:"none"}}
		>
        <div className="view">
		  <button style={{float:"right", color:"red"}} className="destroy" onClick={this._onDestroyClick.bind(this)} >x</button>
          <label onDoubleClick={this._onDoubleClick.bind(this)}>
            {note.title}
          </label>
        </div>
        {input}
      </div>
    );
  }

  _onDoubleClick() {            
    this.setState({isEditing: true});
  }

  _onSave(data) {
    this.props.actions.updateTitle(this.props.note.id, data);
    this.setState({isEditing: false});
  }

  _onDestroyClick() {
    this.props.actions.destroy(this.props.note.id);
  }

}

NoteEditor.propTypes = {
	  note: React.PropTypes.object.isRequired
};

module.exports = NoteEditor;