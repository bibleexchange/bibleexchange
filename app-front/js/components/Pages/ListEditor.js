import React from 'react';
import { browserHistory, Link } from "react-router";
import GoHome from '../Partials/GoHome';
import Footer from '../Partials/List/Footer';
import Header from '../Partials/List/Header';
import ListStore from '../../stores/ListStore';
import MainSection from '../Partials/List/MainSection';

class ListEditor extends React.Component {

	componentWillMount(){
		console.log("List Editor will mount.");		
		this.state = this._getState();
	}
	
	_getState() {
		return {
			data:ListStore.getAll(),
			areAllComplete: ListStore.areAllComplete()
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
	
  render() {
	
    return (
      <div>
			<div className="container">
				<GoHome />
			</div>
			<div className="container">
			<Header data={this.state.data}/>
			<MainSection
			  allItems={this.state.data}
			  areAllComplete={this.state.areAllComplete}
			/>
			<Footer allItems={this.state.data} />
			</div>
      </div>
    )
  }
	
}

module.exports = ListEditor;