import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, IndexRoute, Link, IndexLink, browserHistory } from 'react-router';
import request from 'request';
import bluebird from 'bluebird';

request
  .get('http://derocher.me/wp-json/wp/v2/posts')
  .on('response', function(response) {
    console.log(response.statusCode) // 200
    console.log(response.headers['content-type']) // 'image/png'
	console.log(response);
  })

//const posts =  request.get({url: '',json: true});

class PostStore {
	
	constructor(){
		this._postId = 0;
		this.posts = posts;
	}
	
	post(postId){
		this._postId = postId;
		return this.posts[postId];
	}
	
}
const Store = new PostStore();

const PageFooter = React.createClass({
  render: function() {
  	return (
  	  <footer>
 		<MainNav />
  	  	<p>Copyright 2016 Deliverance Center, Inc.</p>
  	  </footer>
  	)
  }
});



const Home = React.createClass({
  render: function() {
	return(
	  <h1>Home</h1>
	)
  }
});

const PostList = React.createClass({
  render: function() {
  	return(
  	  <div className="post-list">
  	    <p>List of articles</p>
  	    {this.props.children}
  	  </div>
  	)
  }
});

const Articles = React.createClass({
  render: function() {
	return(
		<div>
	  <h1>Articles</h1>

	  <p>{post.title.rendered}</p>
	  </div>
	)
  }
});

const Podcasts = React.createClass({
  render: function() {
	return (
	  <h1>Podcasts</h1>
	)
  }
});

const MainNav = React.createClass({
  render: function() {
	return (
	  <nav>
	    <ul>
          <li><Link to="/">Home</Link></li>
          <li><Link to="/articles">Articles</Link></li>
          <li><Link to="/podcasts">Podcasts</Link></li>
        </ul>
	  </nav>
	)
  }
});

const Logo = React.createClass({
  render: function() {
  	return (
  	  <p>Logo goes here</p>
  	)
  }
});

const MainArticle = React.createClass({
  render: function() {
  	return (
  	  <article>
  	   <p>Article text goes here</p>
  	  </article>
  	)
  }
});

const App = React.createClass({
  render: function() {
    return (
      <div>
        <h1>App</h1>

        {/*
          next we replace `<Child>` with `this.props.children`
          the router will figure out the children for us
        */}
        {this.props.children}

      <PageFooter />
      </div>
      
    )
  }
});


class Post extends React.Component {
  
  componentWillMount(){
	this.state = this._getState(this.props.params.postId);
  }
  
  _getState(postId) {
		return {
			post: Store.post(postId)
			};
  }
  
  componentWillReceiveProps(newProps){
	  let newState = {post:posts[newProps.postId]};
	  this.setState(newState);
  }
  
  render() {  
	
	let post = this.state.post;
	console.log(post.content.rendered);
    return (
      <div> 
		<h1>{post.title.rendered}</h1>
			{/*Necessary as React by default escapes all encoded characters, the only way to set use html tags in this json string is to use  dangerouslySetInnerHTML https://facebook.github.io/react/tips/dangerously-set-inner-html.html*/}
		<div dangerouslySetInnerHTML={{__html:post.content.rendered}} />
      </div>
    );
  }
  
}

setTimeout(function() {
	
console.log("wait a second man! So I can catch up with my hack assync request!");
		   ReactDOM.render((
  <Router history={browserHistory}>
    <Route path="/"component={App}>
	  <IndexRoute component={Home} />
	  <Route component={PostList}>
	    <Route path="/articles" component={Articles} />
        <Route path="/podcasts" component={Podcasts} />
      </Route>
	  <Route path="/post/:postId" component={Post} />
	</Route>
  </Router>
), document.getElementById('root'));

}, 3000);
