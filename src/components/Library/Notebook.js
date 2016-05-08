import React from 'react';
import ONotebookStore from '../../stores/ONotebookStore';
import ActionCreators from '../../actions/LibraryActionCreators';
import Loading from '../Loading';
import GithubNotebook from './GithubNotebook';
import { Link } from 'react-router';

class Notebook extends React.Component {

	componentWillMount(){
		this.state = this._getState();
				
		if(ONotebookStore.getAll().manifestFile){
			ActionCreators.githubNotebookManifest(this.props.params.notebook+"/be-notebook.json");
		}else{
			ActionCreators.githubNotebook(this.props.params.notebook);
		}
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
		if(newProps.notebook !== this.props.notebook){
			ActionCreators.githubNotebookManifest(newProps.notebook+"/be-notebook.json");
		}
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
				<div className="container">
					<Link to="/library" > BACK </Link>
				</div>
			<hr />
			
			<div className="container">
				{this.state.content}
			</div>	
		
		</div>
    )
  }

	loading(){
		console.log('loading data...');
		this.state.content = <h2 style={{textAlign:'center'}}>Loading...<Loading /></h2>;
	}
	error(){
		console.log('Something went wrong :(', this.state.notebook.error);
		this.state.content = this.state.notebook.error.message + " ------- <a href='" + this.state.notebook.error.documentation_url + "'>Read More</a>";
		
		if(!this.state.notebook.notebook.manifestFile && this.state.notebook.notebook.notes.length <= 0){
			setTimeout(()=>{
				ActionCreators.githubNotebook("/"+this.props.params.notebook);
			});
		}else if(this.state.notebook.error.documentation_url === "https://developer.github.com/v3/#rate-limiting"){
			setTimeout(()=>{
				ActionCreators.localNotebook("/"+this.props.params.notebook);
			});
		}
	}
	success(){
		this.state.content = <GithubNotebook notebook={this.state.notebook} />;
	}
	
}

module.exports = Notebook;