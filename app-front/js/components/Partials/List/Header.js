import React from 'react';
import ListActionCreators from '../../../actions/ListActionCreators';
import ListTextInput from './ListTextInput';

class Header extends React.Component {

  render() {
    return (
      <header id="header">
        <h1>{this.props.data.title}</h1>
        <ListTextInput
          id="new-todo"
          placeholder="What needs to be done?"
          onSave={this._onSave}
        />
      </header>
    );
  }

  _onSave(body) {
    if (body.trim()){
		let directive = {body:body,type:"READ_VERSE"};
      ListActionCreators.create(directive);
    }
  }

}

module.exports = Header;