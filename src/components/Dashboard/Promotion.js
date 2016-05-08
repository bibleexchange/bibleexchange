import React from 'react';
import { Grid, Row, Col } from 'react-bootstrap';

require('../../stylesheets/modules/landing.scss');

class Promotion extends React.Component {
 
  render() {
    return (
     		<Grid fluid>			 
			 <Row>
				<Col md={8} mdOffset={2}>
					<div className="embed-container">
						<iframe style={{width:"100%", minHeight:"300px"}} src="https://player.vimeo.com/video/120753625" frameBorder="0" webkitAllowuFullScreen="" mozAllowFullScreen="" allowFullScreen=""></iframe>
					</div>
				</Col>
			</Row>
			<Row className="heading-box" style={{backgroundColor:"#FFB657"}} >
				<Col md={12}>
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
				</Col>	
			</Row>	
			<Row className="heading-box" style={{backgroundColor:"rgb(0, 201, 137)"}}>
				<Col md={12}>
					<h2>We Gain by Trading</h2>
					<div className="center">		
						<p>…when he was returned &hellip; he commanded these servants to be called unto him, &hellip; that he might know how much every man had gained by trading. &mdash; Luke 19:15</p>
					</div>
				</Col>
			</Row>
      </Grid>
    );
  }

}

module.exports = Promotion;