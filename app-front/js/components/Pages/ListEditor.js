import React from 'react';
import { browserHistory, Link } from "react-router";
import GoHome from '../Partials/GoHome';
import Footer from '../Partials/List/Footer';
import Header from '../Partials/List/Header';
import ListStore from '../../stores/ListStore';
import MainSection from '../Partials/List/MainSection';
import ListSectionEditor from '../Partials/List/ListSectionEditor';
import ListActionCreators from '../../actions/ListActionCreators';

class ListEditor extends React.Component {

	componentWillMount(){
		console.log("List Editor will mount.");		
		this.state = this._getState();
	}
	
	_getState() {
		return {
			data:ListStore.getAll(),
			section:ListStore.getSection(this.props.params.section)
		};
	}
 
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		ListStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){	
		console.log('list editor heard a change');
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		ListStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(newProps){
		ListActionCreators.getList(newProps.id);
	}
	
  render() {
	
	console.log(this.props.children);
	
	if( this.props.children !== null){
		var editor = <ListSectionEditor section={this.state.section} />;
	} else {
		var editor = <MainSection allItems={this.state.data} />;
	}
		
    return (
      <div>
			<div className="container">
				<GoHome />
			</div>
			<div className="container">
				<Header data={this.state.data}/>
				{editor}
				<Footer allItems={this.state.data} />
			</div>
      </div>
    )
  }
	
}

module.exports = ListEditor;