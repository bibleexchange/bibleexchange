<!DOCTYPE html>
<html>
	<head>
		@include('partials.meta')
		<link rel="stylesheet" href="/assets/all.css">	
		
		<style>
			hr {border-color:red;}
		</style>	
	</head>

<body>
	<h1>HI</h1>
	<div id="app"></div>
	
	<script type="text/javascript" src="/assets/react.js"></script>	
	<script type="text/javascript" src="/assets/JSXTransformer.js"></script>
	
	<script type="text/jsx;harmony=true" src="/js/components/forms/BibleSearch.js"></script>
	<script type="text/jsx;harmony=true" src="/js/components/BibleNavigation.js"></script>
	<script type="text/jsx;harmony=true" src="/js/components/Bible.js"></script>
	<script type="text/jsx" src="/js/app.js"></script>
	
</body>
</html>