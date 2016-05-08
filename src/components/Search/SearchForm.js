import React from 'react';

class SearchForm extends React.Component {
  
    constructor(props) {
		super(props);
	  }
	
  render() {
	
    return (
		<form method="POST" action="http://localhost/search" accept-charset="UTF-8" className="navbar-form" role="search" id="main-search">
			<input name="_token" type="hidden" value="BYMfxYPhM0X6cMTMeLGAnfZ8Um9EHmY8X7g3SlpQ" />
			<div className="input-group">
				<span className="input-group-btn">
					<button type="submit" className="btn btn-default">
						<span className="glyphicon glyphicon-search">
							<span className="sr-only">Search...</span>
						</span>
					</button>
			</span>
			<input placeholder="Search..." className="form-control ellip" name="q" type="search" />
			</div>
		</form>
    )
  }
}

module.exports = SearchForm;