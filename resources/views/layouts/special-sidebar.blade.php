<!-- The following ".site" is essential to the sidebar behavior -->
<div class="container-fluid">
	<div id="studies" class="row site">
		<div id="sidebar" class="col-md-3" style="position:relative; top:0;" >
			<div class="sidebar">
				<div id="masthead" class="site-header" role="banner">
	
						@yield('sidebar-main')
						
						<a id="secondary-toggle" data-toggle="collapse" href="#sidebar-collapse" aria-expanded="false" aria-controls="collapseExample">
							<div class="sidebar-block greenBG">
								<h2><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></h2>
							</div>
						</a>
						
				</div><!-- .site-header -->
	
				<div id="secondary" class="secondary">
					
					@yield('sidebar-secondary')
					
				</div><!-- .secondary -->
			</div>
		</div><!-- .sidebar -->
		
		<div id="content" class="site-content col-md-9">
			<!-- Main Content Goes Here like "TEXTBOOK"-->
			
			@yield('main-content')
			
		</div><!-- .site-content -->
		
	</div><!-- .row -->
	
</div><!-- .container-fluid -->