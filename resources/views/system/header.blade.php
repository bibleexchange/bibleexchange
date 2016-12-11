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
    {{ HTML::style('assets/css/bootstrap.min.css')}}
    {{ HTML::style('assets/css/font-awesome.min.css')}}

    @if(Auth::check())
      {{ HTML::style('assets/css/morris.min.css')}}
      {{ HTML::style('assets/css/app.css')}}
    @else
      {{ HTML::style('assets/css/walledgarden.css')}}
    @endif
	{{ HTML::style('/assets/css/page-transitions.css')}}

	<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.2.1/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.2.1/react-dom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/1.6.2/remarkable.min.js"></script>
		
  @yield('head')

</head>
<body>

	@yield('body')
	
	@yield('footer')
	
	@yield('scripts')

</body>
</html>