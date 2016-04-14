import React from 'react';

class Promotion extends React.Component {
 
  render() {
    return (
     		<div className="container-fluid wrapper">			 
			 <div className="row">
				<div className="col-md-8 col-md-offset-2">
					<div className="embed-container">
						<iframe style={{width:"100%", minHeight:"300px"}} src="https://player.vimeo.com/video/120753625" frameBorder="0" webkitAllowuFullScreen="" mozAllowFullScreen="" allowFullScreen=""></iframe>
					</div>
				</div>
			</div>
			<div className="row heading-box" style={{backgroundColor:"#FFB657"}} >
				<div className="col-md-12">
					<h2>Launched February 20, 2015</h2>
					<p>Journey with Us While We Grow</p>
					
					<p>
						<a href="https://twitter.com/bible_exchange">
							<img className="logo center-block" src="/svg/twitter-logo.svg" alt="follow us on Twitter" />
						</a>
						<a href="https://www.facebook.com/thebibleexchange">
							<img className="logo center-block" src="/svg/facebook-logo.svg" alt="like us on Facebook" />
						</a>
					</p>
				</div>	
			</div>	
			<div className="row heading-box" style={{backgroundColor:"rgb(0, 201, 137)"}}>
				<div className="col-md-12">
					<h2>We Gain by Trading</h2>
					<div className="center">		
						<p>…when he was returned … he commanded these servants to be called unto him, … that he might know how much every man had gained by trading. — Luke 19:15</p>
					</div>
				</div>
			</div>
      </div>
    );
  }

}

module.exports = Promotion;