import React from 'react';
import { Link } from 'react-router';
import classNames from 'classNames';
import NotebookActionCreators from '../../actions/NotebookActionCreators';
import TextInput from '../TextInput';

class Note extends React.Component {

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
	var notebook = this.props.notebook;
 
    var input;
    if (this.state.isEditing) {
      input =
        <TextInput
          className="edit"
          onSave={this._onSave.bind(this)}
          value={note.title}
        />;
    }

    return (
      <Link
        className={classNames({
          'editing': this.state.isEditing
        })}
        key={note.id}
		style={{width:"100%", border:"solid 1px gray",listStyleType:"none", margin:"10px", padding:"10px",marginLeft:"none"}}
		to={"/user/"+notebook.id+"/"+note.id}
		>
        <div className="view">
		  <button style={{float:"right", color:"red"}} className="destroy" onClick={this._onDestroyClick.bind(this)} >x</button>
          <label onDoubleClick={this._onDoubleClick.bind(this)}>
            {note.title}
          </label>
        </div>
        {input}
      </Link>
    );
  }

  _onDoubleClick() {            
    this.setState({isEditing: true});
  }

  _onSave(data) {
    NoteActions.update(this.props.note.id,{title:data});
    this.setState({isEditing: false});
  }

  _onDestroyClick() {
    NotebookActions.destroy(this.props.note.id);
  }

}

Note.propTypes = {
	  notebook: React.PropTypes.object.isRequired,
	  note: React.PropTypes.object.isRequired
};

module.exports = Note;