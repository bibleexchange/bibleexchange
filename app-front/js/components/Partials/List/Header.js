import React from 'react';
import ListActionCreators from '../../../actions/ListActionCreators';

class Header extends React.Component {

  render() {
    return (
      <header id="header">
        <h1>{this.props.data.title}</h1>
      </header>
    );
  }
/*
  _onSave(body) {
    if (body.trim()){
		let directive = {body:body,type:"READ_VERSE"};
      ListActionCreators.create(directive);
    }
  }
*/
}

module.exports = Header;