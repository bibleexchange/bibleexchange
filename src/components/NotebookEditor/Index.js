import React from 'react';
import { browserHistory, Link } from "react-router";
import Footer from './Footer';
import NotebookStore from '../../stores/NotebookStore';
import MainSection from './MainSection';
import NotebookActionCreators from '../../actions/NotebookActionCreators';

class NotebookEditorIndex extends React.Component {

	componentWillMount(){
		console.log("List Editor will mount.");		
		this.state = this._getState();
	}
	
	_getState() {
		return {
			data:NotebookStore.getAll(),
			section:NotebookStore.getSection(this.props.params.section)
		};
	}
 
	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		NotebookStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){	
		console.log('list editor heard a change');
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		console.log("Bible will Unmount");
		NotebookStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(newProps){
		NotebookActionCreators.getList(newProps.id);
	}
	
  render() {		
    return (
      <div>
			<div className="container">
				<MainSection allItems={this.state.data} />
				<Footer allItems={this.state.data} />
			</div>
      </div>
    )
  }
	
}

module.exports = NotebookEditorIndex;