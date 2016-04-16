import React from 'react';
import ONotebookStore from '../../stores/ONotebookStore';
import ActionCreators from '../../actions/LibraryActionCreators';
import Loading from '../Loading';
import GithubNotebook from './GithubNotebook';
import { Link } from 'react-router';

class Notebook extends React.Component {

	componentWillMount(){
		this.state = this._getState();
		ActionCreators.githubNotebookManifest(this.props.params.notebook+"/be-notebook.json");
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
	
	componentWillReceiveProps(newProps){
		ActionCreators.githubNotebook(newProps.notebook);
	}
	
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
		<div>
			<hr />
			<Link to="/library" > BACK </Link>
			<hr />
			
			<div id="minimal-list" className="container">
				{this.state.content}
			</div>	
			
			{this.props.children}
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
		this.state.content = <GithubNotebook notebook={this.state.notebook} />;
	}
	
}

module.exports = Notebook;