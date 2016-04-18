import React from 'react';
import { Link } from 'react-router';
import GithubNote from './GithubNote';

class GithubNotebook extends React.Component {
	
  render() { 
	const notebook = this.props.notebook;
	var section = "";
	var sectionTest = false;
	let notes = this.props.notebook.notes.map(function(n,key){
					
					if(n.section && n.section != sectionTest){
						sectionTest = n.section;
						section = "<h2>"+n.section+"</h2>";
					}else{
						section = "";
					}
					
					if(n.name.charAt(0) !== '_'){
						return (<div key={key}><div dangerouslySetInnerHTML={{__html: section}} ></div><li><GithubNote notebook={notebook} key={Math.random()} note={n} basePath="/library/" /></li></div>);
					}
				});

	return (<div id="minimal-list">				
				<h1>{notebook.name}</h1>
				<ul>
					{notes}
				</ul>
			</div>);
	}
  
}

module.exports = GithubNotebook;