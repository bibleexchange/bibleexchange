import React from 'react';
import LinkedStore from '../../stores/LinkedStore';
import LibraryActionCreators from '../../actions/LibraryActionCreators';
import GithubDirectory from './GithubDirectory';
import Loading from '../Loading';
		
class LinkedIndex extends React.Component {

	componentWillMount(){
		this.state = this._getState();
		
		LibraryActionCreators.githubManifest('be-manifest.json');
	}
	
	_getState() {
		return {
			repos:LinkedStore.getAll(),
			content: '',
			display: this.props.params.notebook ? "none":"block"
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
	
	componentWillReceiveProps(){
		LibraryActionCreators.githubDirectory();
	}
	
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
		<div id="minimal-list" className="container" >	
			<div style={{display:this.state.display}}>
				<h1>{this.state.repos.name ? this.state.repos.name+" Library":"Library"}</h1>
				
				<center><h4>{this.state.repos.description}</h4></center>
				
				<ul>
				{this.state.content}
				</ul>
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
		console.log('Something went wrong :(', this.state.repos.error);
		this.state.content = this.state.repos.error.message;
	}
	success(){
		this.state.content = this.state.repos.gh.map((f)=>{
	
			if(f.name.charAt(0) !== '_'){
				return <GithubDirectory key={Math.random()} course={f} base_path="/library/" />;
			}
			});
	}
	
}

module.exports = LinkedIndex;