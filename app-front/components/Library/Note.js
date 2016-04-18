import React from 'react';
import NoteStore from '../../stores/NoteStore';
import ActionCreators from '../../actions/LibraryActionCreators';
import Loading from '../Loading';
import GithubNoteFull from './GithubNoteFull';
		
class Note extends React.Component {

	componentWillMount(){
		this.state = this._getState();
		ActionCreators.githubFile(this.props.params.notebook+"/"+this.props.params.note, true);
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
		ActionCreators.githubFile(newProps.notebook+"/"+newProps.note,false);
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
this.loading();
    return (
	<div>{this.state.content}</div>
    )
  }
	
	loading(){
		console.log('loading data...');
		this.state.content = <h2 style={{textAlign:'center'}}>Loading...<Loading /></h2>;
	}
	error(){
		console.log('Something went wrong :(', this.state.note.error);
		this.state.content = <div className='container'><p dangerouslySetInnerHTML={{__html:this.state.note.error.message + " ------- Read more: " + this.state.note.error.documentation_url }}
							></p></div>;
	}
	success(){
		this.state.content = <GithubNoteFull backURL={"/library/"+this.props.params.notebook} data={this.state.note} />;
	}
}

module.exports = Note;