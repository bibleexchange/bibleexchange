import React from 'react';
import ONotebookStore from '../../stores/ONotebookStore';
import LinkedActionCreators from '../../actions/LinkedActionCreators';
import Loading from '../Loading';
import GithubNote from './GithubNote';

class Notebook extends React.Component {

	componentWillMount(){
		this.state = this._getState();
		
		LinkedActionCreators.githubNotebook(this.props.params.notebook);
	}
	
	_getState() {
		return {
			notebook:ONotebookStore.getAll(),
			content: ''
		};
	}

	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		ONotebookStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){	
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		ONotebookStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(){}
	
  render() {
	
	let r = this.state.notebook;
	let content = '';
	
	if(r.loading){
		this.loading();
	}else if(r.error){
		this.error();
	}else{
		this.success();
	}

    return (
		<div className="container">			
		{this.state.content}
		</div>
    )
  }
	
	loading(){
		console.log('loading data...');
		this.state.content = <h2 style={{textAlign:'center'}}>Loading...<Loading /></h2>;
	}
	error(){
		console.log('Something went wrong :(', this.state.notebook.error);
		this.state.content = this.state.notebook.error.message;
	}
	success(){
		this.state.content = this.state.notebook.notes.map((n)=>{
			console.log(n);
			if(n.name.charAt(0) !== '_'){
				return <GithubNote key={Math.random()} data={n} />;
			}
			});
	}
	
}

module.exports = Notebook;