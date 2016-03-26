import React from 'react';
import ListActions from '../../../actions/ListActionCreators';
import ListSection from './ListSection';
import ListTextInput from './ListTextInput';
import ListActionCreators from '../../../actions/ListActionCreators';

class MainSection extends React.Component {
	onComponentDidMount(){
		this.mainStyle = {width:"100%"};
		this.listStyle = {width:"100%", listStyleType:"none",marginLeft:"0",paddingLeft:"0"};
	}
	
render() {

    if (Object.keys(this.props.allItems).length < 1) {
      return null;
    }

    var allItems = this.props.allItems.sections;
    var items = [];

    for (var key in allItems) {
      items.push(<ListSection key={key} section={allItems[key]} />);
    }

    return (
	<div className="container">	
		  <section id="main" style={this.mainStyle}>
			<ul style={this.listStyle} id="bible-list">{items}</ul>
				<ListTextInput
				  id="new-item"
				  placeholder="What needs to be done?"
				  onSave={this._onSave}
				/>
		  </section>
		  <div className="push"></div>
	  </div>
    );
  }
	
_onSave(title) {
    if (title.trim()){
	   let directive = {title:title,type:"READ_VERSE"};
       ListActionCreators.create(directive);
    }
  }
	
}

MainSection.propTypes = {
	allItems: React.PropTypes.object.isRequired
};

module.exports = MainSection;