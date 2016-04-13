import React from 'react';
import LinkedStore from '../../stores/LinkedStore';
import LinkedActionCreators from '../../actions/LinkedActionCreators';
import GithubDirectory from './GithubDirectory';
import Loading from '../Loading';
		
class LinkedIndex extends React.Component {

	componentWillMount(){
		this.state = this._getState();
		
		LinkedActionCreators.githubDirectory();
	}
	
	_getState() {
		return {
			repos:LinkedStore.getAll(),
			content: ''
		};
	}

	componentDidMount(){	
		this.changeListener = this._onChange.bind(this);	
		LinkedStore.addChangeListener(this.changeListener);
	}
	
	_onChange(){	
		let newState = this._getState();
		this.setState(newState);		
	}
	
	componentWillUnmount(){
		LinkedStore.removeChangeListener(this.changeListener);
	}
	
	componentWillReceiveProps(){}
	
  render() {
	
	let r = this.state.repos;
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
		this.state.content = this.state.repos.gh.map((f)=>{
			
			if(f.name.charAt(0) !== '_'){
				return <GithubDirectory key={Math.random()} course={f} />;
			}
			});
	}
	
}

module.exports = LinkedIndex;