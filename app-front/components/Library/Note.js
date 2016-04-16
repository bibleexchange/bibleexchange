import React from 'react';
import NoteStore from '../../stores/NoteStore';
import ActionCreators from '../../actions/LibraryActionCreators';
import Loading from '../Loading';
import GithubNoteFull from './GithubNoteFull';
		
class Note extends React.Component {

	componentWillMount(){
		this.state = this._getState();
		let file = "/"+this.props.params.notebook+"/"+this.props.params.note;
		console.log(file);
		ActionCreators.githubFile(file);
	}
	
	_getState() {
		return {
			note:NoteStore.getAll(),
			content: ''
		};
	}

	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		NoteStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){	
		let newState = this._getState();
		this.setState(newState);		
	}

	componentWillUnmount(){
		NoteStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(newProps){
		
		let file = "/"+newProps.notebook+"/"+newProps.note;
		console.log(file);
		
		ActionCreators.githubFile(file);
	}
	
  render() {
	
	let r = this.state.note;
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
		console.log('Something went wrong :(', this.state.repos.error);
		this.state.content = this.state.repos.error.message;
	}
	success(){
		this.state.content = <GithubNoteFull backURL={"/library/"+this.props.params.notebook} data={this.state.note} />;

	}
	
}

module.exports = Note;