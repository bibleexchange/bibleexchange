import React from 'react';

class PasswordResetForm extends React.Component {
    
  render() {
	
    return (
	<div className="row">
        <div className="col-md-6">
            <h1>Need to reset your password?</h1>
			<form method="POST" action="http://bible.exchange/password/remind" accept-charset="UTF-8">
				<label for="email">Email:</label>
			   <input className="form-control" required="required" name="email" type="email" id="email" />
				<div className="form-group">
					<input className="btn btn-primary form-control" type="submit" value="Reset Password" />
				</div>
            </form>
        </div>
    </div>
    );
  }
}

module.exports = PasswordResetForm;