import React from 'react';
import Note from './Note';
import TextInput from './TextInput';
import NoteActionCreators from '../actions/NoteActionCreators';

class NotesList extends React.Component {
	
	onComponentWillMount(){
		this.mainStyle = {width:"100%"};
		this.listStyle = {width:"100%", listStyleType:"none", marginLeft:"0px", paddingLeft:"0px"};
	}
	
render() {

    var notes = this.props.notes;
    var items = [];
	
	if(notes !== null){
		for (var key in notes) {
		  items.push(<Note key={key} data={notes[key]} />);
		}
	}
	
    return (
	<div className="container">	
		<div className="row">
			<div className="col-md-12">
			  <section id="main" style={this.mainStyle}>

				<ul style={this.listStyle} id="bible-list">{items}</ul>

				<TextInput
				  id="new-item"
				  placeholder="What is on your mind?"
				  onSave={this._onSave.bind(this)}
				/>
			  </section>
		 </div>
		</div>
		  <div className="push"></div>
	  </div>
    );
  }
	
_onSave(body) {
    if (body.trim()){
	   let note = {body:body, bible_verse_id:this.props.verse.id};
       NoteActionCreators.create(note);
    }
  }
	
}

NotesList.propTypes = {
	notes: React.PropTypes.array.isRequired
};

module.exports = NotesList;