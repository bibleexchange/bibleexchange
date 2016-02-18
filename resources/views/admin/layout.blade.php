@extends('layouts.default')

@section('content')

    <div id="sub_be_banner" class="row" style="background-color:gray;">
		<div class="col-xs-12">
			<h1>Admin Area</h1>
		</div>
    </div>

	<div class="row" id="admin">
		<!-- Navbar -->
		<nav class="col-sm-3" >
            
			<ul class="nav">
				<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin') }}}"><span class="glyphicon glyphicon-home"></span> Admin</a></li>
				<li{{ (Request::is('admin/lessons*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/lessons') }}}"><span class="glyphicon glyphicon-list-alt"></span> Lessons</a></li>
				<li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bullhorn"></span> Comments</a></li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}">
						<span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
						<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
					</ul>
				</li>
				
				<li class="{{ (Request::is('admin/transcripts*') ? ' active' : '') }}">
					<a href="{{{ URL::to('admin/transcripts') }}}">
						<span class="glyphicon glyphicon-user"></span> Transcripts
					</a>

				</li>
				
				
				<!-- Misc Resources START -->
				
				<li class="dropdown{{ (Request::is('admin/plans*|admin/users*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-user"></span> Resources <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/plans*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/plans') }}}"><span class="glyphicon glyphicon-user"></span> Plans</a></li>
						<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> ##</a></li>
					</ul>
				</li>
				
				<!-- Misc Resources END -->
				
			</ul>
		</nav>
		
		<div class="col-sm-9">
		
		@yield('window')
		
	</div>


	</div>
	<!-- ./ container -->
	
    @stop
