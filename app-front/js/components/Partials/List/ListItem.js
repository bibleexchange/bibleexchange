import React from 'react';
import classNames from 'classNames';
import ListActions from '../../../actions/ListActionCreators';
import ListTextInput from './ListTextInput';

class ListItem extends React.Component {

	componentWillMount(){	
		this.state = this._getState();
	}
	
	_getState() {
		return {
			isEditing:false
		};
	}

  render() {
    var item = this.props.item;

    var input;
    if (this.state.isEditing) {
      input =
        <ListTextInput
          className="edit"
          onSave={this._onSave.bind(this)}
          value={item.body}
        />;
    }

    return (
      <li
        className={classNames({
          'completed': item.complete,
          'editing': this.state.isEditing
        })}
        key={item.id}>
        <div className="view">
          <input
            className="toggle"
            type="checkbox"
            checked={item.complete}
            onChange={this._onToggleComplete.bind(this)}
          />
          <label onDoubleClick={this._onDoubleClick.bind(this)}>
            {item.body}
          </label>
          <button className="destroy" onClick={this._onDestroyClick.bind(this)} >
		  x
		  </button>
        </div>
        {input}
      </li>
    );
  }

  _onToggleComplete() {
    ListActions.toggleComplete(this.props.item);
  }

  _onDoubleClick() {            
    this.setState({isEditing: true});
  }

  _onSave(data) {
    ListActions.updateItem(this.props.item.id, data);
    this.setState({isEditing: false});
  }

  _onDestroyClick() {
    ListActions.destroy(this.props.item.id);
  }

}

ListItem.propTypes = {
	  item: React.PropTypes.object.isRequired
};

module.exports = ListItem;