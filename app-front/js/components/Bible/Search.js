import React from 'react';

class Search extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	  
	var user = this.props.user;
	const currentChapter = this.props.currentChapter;
	const styles = {
		formStyle : {
			display:'inline-block'
		}, 
		btnSubmitStyle : {
			border:'none', 
			background:'transparent'
		}
	};
		
    return (
		<form id ="bibleSearch" role="search" action="/bible/search'" method="POST" style={styles.formStyle}>
					
	<button type="submit" className="btn btn-default" style={styles.btnSubmitStyle}>
		<span className="glyphicon glyphicon-search">
			<span className="sr-only">Search...</span>
		</span>
	</button>
	
	<input name="q" id="reference" placeholder={currentChapter.reference}
		style={{height:'100%',  margin:'0',  border:'1.11px',  padding:'4.5px',  display:'inline-block',  verticalAlign:'middle', background:'transparent',  textAlign:'center', maxWidth:'150px', background:'rgba(255,255,255,.1)'}}
	></input>

		</form>		

    )
  }
}

module.exports = Search;