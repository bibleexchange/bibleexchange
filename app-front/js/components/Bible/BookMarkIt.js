import React from 'react';

class BookMarkIt extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	  
	var user = this.props.user;

    return (
		<form action="/user/bookmarks" method="POST" style={{display:'inline-block'}}>
			<input type="hidden" name="url" value="{!! Request::url() !!}" ></input>
			<button type="submit" value="Next"className="btn btn-default" style={{border:'none',background:'transparent'}}>
				<span className="glyphicon glyphicon-bookmark"></span>
			</button>
		</form>		

    )
  }
}

module.exports = BookMarkIt;