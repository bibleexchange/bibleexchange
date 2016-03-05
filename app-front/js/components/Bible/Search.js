import React from 'react';

class Search extends React.Component {
  
    constructor(props) {
		super(props);
	  }
  
  render() {
	  
	const styles = {
		formStyle : {
			display:'inline-block'
		}, 
		btnSubmitStyle : {
			border:'none', 
			background:'transparent'
		},
		inputStyle: {height:'100%',  margin:'0',  border:'1.11px',  padding:'4.5px',  display:'inline-block',  verticalAlign:'middle', background:'transparent',  textAlign:'center', maxWidth:'150px', background:'rgba(255,255,255,.1)'}
	};
		
    return (
		<form id ="bibleSearch" role="search" style={styles.formStyle}>
			<button type="submit" className="btn btn-default" style={styles.btnSubmitStyle}  onClick={this.props.submitHandler}>
				<span className="glyphicon glyphicon-search">
					<span className="sr-only">Search...</span>
				</span>
			</button>
			
			<input type="text" name="q" id="reference" value={this.props.term} onChange={this.props.changeHandler}
				style={styles.inputStyle}
			></input>
		</form>

    )
  }
}

module.exports = Search;