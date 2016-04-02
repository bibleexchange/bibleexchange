import React from 'react';
import UserActionCreators from '../actions/UserActionCreators';

class BookMarkIt extends React.Component {
  
  render() {	  
    return (
		<button onClick={this.handleBookMark.bind(this)} type="submit" value="Next"className="btn btn-default" style={{border:'none',background:'transparent',display:'inline-block'}}>
			<span className="glyphicon glyphicon-bookmark"></span>
		</button>
    )
  }
  
  	handleBookMark(event) {
		UserActionCreators.bookMarkIt(this.props.url,this.props.token);
	}
}

BookMarkIt.propTypes = { 
	token: React.PropTypes.string.isRequired,
	url: React.PropTypes.string.isRequired
	};

module.exports = BookMarkIt;