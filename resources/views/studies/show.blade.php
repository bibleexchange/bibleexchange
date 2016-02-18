<!DOCTYPE html>
<html>
	<head>
		@include('partials.meta')
		<link rel="stylesheet" href="/assets/all.css">
		
		<style>
			<!-- INCLUDE:  partials.userConditionalCSS -->
			@include('partials.userConditionalCSS')
		</style>
		
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans&subset=latin">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Arvo&subset=latin">

	</head>

<body class="admin-bar">

		<?php
			$search_form = Form::open(['route'=>'search_path','class'=>'navbar-form','role'=>'search','id'=>'main-search'])	
						.'<div class="input-group">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-default">
									<span class="glyphicon glyphicon-search">
										<span class="sr-only">Search...</span>
									</span>
								</button>
							</span>'.
						
							 Form::input('search','q', null, ['placeholder'=>'Search...','class'=>'form-control ellip'])
		
						.'</div>'.
					Form::close();	
		?>

	@include('partials.main-nav')
	
		<!-- Content -->
		@include('studies.special-view-extended-2')
		<!-- ./ content -->	
	
	@include('partials.main-footer')
	
	<script type='text/javascript'>
		/* <![CDATA[ */
		var screenReaderText = {"expand":"<span class=\"screen-reader-text\">expand child menu<\/span>","collapse":"<span class=\"screen-reader-text\">collapse child menu<\/span>"};
		/* ]]> */
	</script>

	<script src="/assets/all.js"></script>
		
	<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-51587144-2', 'auto');
	  ga('send', 'pageview');
	</script>

	<!--  INCLUDE: studies.partials.study-editor-js -->
	@include('studies.partials.study-editor-js')

</body>
</html>