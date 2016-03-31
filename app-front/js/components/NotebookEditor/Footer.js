var React = require('react');
var ReactPropTypes = React.PropTypes;
var NotebookActionCreators = require('../../actions/NotebookActionCreators');

var Footer = React.createClass({

  propTypes: {
    allItems: ReactPropTypes.object.isRequired
  },

  render: function() {
    var allItems = this.props.allItems.sections;
    var total = Object.keys(allItems).length;

    if (total === 0) {
      return null;
    }

    var completed = 0;
    for (var key in allItems) {
      if (allItems[key].complete) {
        completed++;
      }
    }

    var itemsLeft = total - completed;
    var itemsLeftPhrase = itemsLeft === 1 ? ' item ' : ' items ';
    itemsLeftPhrase += 'left';

    // Undefined and thus not rendered if no completed items are left.
    var clearCompletedButton;
    if (completed) {
      clearCompletedButton =
        <button
          id="clear-completed"
          onClick={this._onClearCompletedClick}>
          Clear completed ({completed})
        </button>;
    }

  	return (
      <footer id="footer">
        <span id="todo-count">
          <strong>
            {itemsLeft}
          </strong>
          {itemsLeftPhrase}
        </span>
        {clearCompletedButton}
      </footer>
    );
  },

  _onClearCompletedClick: function() {
    NotebookActionCreators.destroyCompleted();
  }

});

module.exports = Footer;