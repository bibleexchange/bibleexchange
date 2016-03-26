import React from 'react';
import classNames from 'classNames';
import ListActions from '../../../actions/ListActionCreators';
import ListTextInput from './ListTextInput';

class ListSection extends React.Component {

	componentWillMount(){	
		this.state = this._getState();
	}
	
	_getState() {
		return {
			isEditing:false
		};
	}

  render() {
    var section = this.props.section;

    var input;
    if (this.state.isEditing) {
      input =
        <ListTextInput
          className="edit"
          onSave={this._onSave.bind(this)}
          value={section.title}
        />;
    }

    return (
      <li
        className={classNames({
          'editing': this.state.isEditing
        })}
        key={section.id}
		style={{width:"100%", border:"solid 1px gray",listStyleType:"none", margin:"10px", padding:"10px",marginLeft:"none"}}
		>
        <div className="view">
		  <button style={{float:"right", color:"red"}} className="destroy" onClick={this._onDestroyClick.bind(this)} >x</button>
          <label onDoubleClick={this._onDoubleClick.bind(this)}>
            {section.title}
          </label>
        </div>
        {input}
      </li>
    );
  }

  _onDoubleClick() {            
    this.setState({isEditing: true});
  }

  _onSave(data) {
    ListActions.updateSectionTitle(this.props.section.id, data);
    this.setState({isEditing: false});
  }

  _onDestroyClick() {
    ListActions.destroy(this.props.section.id);
  }

}

ListSection.propTypes = {
	  section: React.PropTypes.object.isRequired
};

module.exports = ListSection;