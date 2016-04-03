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

    if (Object.keys(this.props.notes).length < 1) {
      return null;
    }

    var notes = this.props.notes;
    var items = [];

    for (var key in notes) {
      items.push(<Note key={key} data={notes[key]} />);
    }

    return (
	<div className="container">	
		<div className="row">
			<div className="col-md-12">
			  <section id="main" style={this.mainStyle}>

				<ul style={this.listStyle} id="bible-list">{items}</ul>

				<TextInput
				  id="new-item"
				  placeholder="What needs to be done?"
				  onSave={this._onSave}
				/>
			  </section>
		 </div>
		</div>
		  <div className="push"></div>
	  </div>
    );
  }
	
_onSave(title) {
    if (title.trim()){
	   let directive = {title:title,type:"READ_VERSE"};
       NoteActionCreators.create(directive);
    }
  }
	
}

NotesList.propTypes = {
	notes: React.PropTypes.object.isRequired
};

module.exports = NotesList;