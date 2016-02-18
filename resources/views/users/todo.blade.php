<!DOCTYPE html>
<html ng-app="myApp">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <title>Simple Angular APP</title>
  
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
  
        <base href="/">
    </head>
  
    <body>
  
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Ticket</a>
                </div>
  
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="/settings">Settings</a>
                        </li>
                    </ul>
  
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
  
        <div ng-view></div>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
        <script src="https://code.angularjs.org/1.2.8/angular-route.js"></script>
        <script src="/assets/main.js"></script>
    </body>
</html>