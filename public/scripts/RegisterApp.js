var EzField = React.createClass({

  render: function() {
	  
	  var field = false;
	  
	  switch(this.props.type) {
		case "hidden":
			field = <input name={this.props.name} type={this.props.type} value={this.props.value} />;
			break;
		case "submit":
			field = 
				<div className="form-group">
				  <div className="col-sm-8 col-sm-offset-4">
					<input className="btn btn-primary" type={this.props.type} value={this.props.value} />
				  </div>
				</div>;
			break;
		default:
			field = <div className="form-group">
				  <label htmlFor="name" className="col-sm-4 control-label">{this.props.label}</label>
				  <div className="col-sm-8">
					<input className="form-control" required={this.props.required} name={this.props.name} type={this.props.type} value={this.props.value} id={this.props.name} />
				  </div>
				</div>;
	}

	  
    return (field);
  }
});


var EzForm = React.createClass({

  render: function() {
    return (
		<form method={this.props.method} action={this.props.action} acceptCharset="UTF-8" className="form-horizontal">
			{this.props.fields.map(function(f,i){
				return <EzField key={i} {...f}/>;
			})}
		 </form>
    );
  }
});

var RegisterApp = React.createClass({
  render: function() {
    return (
      <div>
		<h1 className="col-sm-8 col-sm-offset-4">{ this.props.header}</h1>
        <EzForm method={this.props.data.method} action={this.props.data.action} fields={this.props.data.fields} />
      </div>
    );
  }
});

const el = document.getElementById('register-app');
var store = JSON.parse(el.attributes.data.value);

ReactDOM.render(
  <RegisterApp header="Register" data={store} />,
  el
);