import React from 'react';
import { Link } from "react-router";

class BibleChaptersList extends React.Component {
  
    constructor(props) {
		super(props);	
	  }
  
  render() {
	var book = this.props.book;
	
	var chapters  = [];

	for (var i=1; i <= book.chapters; i++) {
		chapters.push(i);
	}
	
	const toggle = this.props.toggle;
	const getChapter = this.props.getChapter;
	
    return (
		<div>
			{chapters.map(function(chapter) {
			  return (
				<li className="square-list" key={chapter}>
					<Link to={"/bible/"+book.slug+"/"+chapter} id={chapter} onClick={toggle.bind(this)}>
						{chapter}
					</Link>
				</li>
			 )})}
		</div>			

    )
  }
}

class BibleBook extends React.Component {
  
  constructor(props) {
	super(props);	
	this.state = {
		  collapsed: false,
		};
  }
	
  toggleChapter(e) {
	e.preventDefault(); 
    const collapsed = !this.state.collapsed;
    this.setState({collapsed});
  }
  
  toggleChapterAlways() {
    const collapsed = false;
    this.setState({collapsed});
	this.props.closeAll();
  }
  
  render() {
	const { collapsed } = this.state;
	const chaptersClass = collapsed ? "collapse" : "";
	const book = this.props.book;
	
	return (
		<div className="btn-group" key={book.id}>
			  <a className="btn btn-default" onClick={this.toggleChapter.bind(this)} href="#" style={{width:'75px', height:'50px', overflow:'hidden'}}>
				<strong>{book.n.substring(0,4)}</strong>
			  </a>
			  <ul className={"dropdown-menu" + chaptersClass} role="menu" >
				
				<BibleChaptersList book={book} toggle={this.toggleChapterAlways.bind(this)} />

			  </ul>
			</div>
		)
  }
}

class BibleBooksList extends React.Component {
  
    constructor(props) {
		super(props);		
	  }
  
  render() {
	
	const books = this.props.books;
	const closeAll = this.props.closeAll;
	const getChapter = this.props.getChapter;
	
    return (
		<div>
			{books.map(function(book) {
			  return <BibleBook book={book} key={book.id} closeAll={closeAll} />
			 })}
		</div>			

    )
  }
}

module.exports = BibleBooksList;