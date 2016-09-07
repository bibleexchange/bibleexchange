<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <title>
      Bible Experience: the learning record store (LRS) for Bible exchange
    </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">	

<style>
  html, body {
	height:99%; margin:0; padding:0;
	border-left:#F9CA73 5px solid;
	border-top:#00C97C 5px solid;
	border-right:#E55C46 5px solid;
	border-bottom:#317FB6 5px solid; 
}

  #big-box {
    margin: auto;
    width: 50%;
  }

</style>
	
</head>
<body>  
      <div style="text-align:center; color:gray; margin-top:100px;">
        <h1>Bible exchange</h1>
	<p>Log in or Register</p>
      </div>
  
@if (Auth::check())
    <a href="/logout">Logout</a><br />
@else
	<div id="big-box">
	<input type="image" src="/assets/img/be_logo.png" name="login"  style="width:400px; display:block; margin: auto; width: 40%;" id="login-button" />
	</div>
    <script src="https://cdn.auth0.com/js/lock/10.0/lock.min.js"></script>
    <script type="text/javascript">
       
var options = {
  auth: {
    responseType: 'code',
    params: {scope: 'openid name email'},
    redirectUrl: '{{ env ("AUTH0_CALLBACK_URL" )}}',
  }
}; 

 var lock = new Auth0Lock('{{ env("AUTH0_CLIENT_ID") }}', '{{ env("AUTH0_DOMAIN") }}', options);
        var $loginButton = document.getElementById("login-button");
        $loginButton.addEventListener("click", function () {
            lock.show();
        });

// Listening for the authenticated event
lock.on("authenticated", function(authResult) {
  // Use the token in authResult to getProfile() and save it to localStorage
  lock.getProfile(authResult.idToken, function(error, profile) {
    if (error) {
      // Handle error
      return;
    }

    localStorage.setItem('idToken', authResult.idToken);
    localStorage.setItem('profile', JSON.stringify(profile));
  });
});

	lock.show();

	</script>
@endif
		
      </div>

    </div>  

</body>
</html>
