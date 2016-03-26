import React from 'react';
import ListActions from '../../../actions/ListActionCreators';
import ListItem from './ListItem';

class MainSection extends React.Component {
	
render() {

    if (Object.keys(this.props.allItems).length < 1) {
      return null;
    }

    var allItems = this.props.allItems.directives;
    var items = [];

    for (var key in allItems) {
      items.push(<ListItem key={key} item={allItems[key]} />);
    }

    return (
      <section id="main">
        <input
          id="toggle-all"
          type="checkbox"
          onChange={this._onToggleCompleteAll}
          checked={this.props.areAllComplete ? 'checked' : ''}
        />
        <label htmlFor="toggle-all">Mark all as complete</label>
        <ul id="bible-list">{items}</ul>
      </section>
    );
  }

  _onToggleCompleteAll() {
    ListActions.toggleCompleteAll();
  }
	
}

MainSection.propTypes = {
	allItems: React.PropTypes.object.isRequired,
	areAllComplete: React.PropTypes.bool.isRequired
};

module.exports = MainSection;