	<nav id="menu" class="navbar navbar-default navbar-static-top animated" style="top:0">
        <div class="container-fluid">
          <div class="navbar-header">
	         
            <button id="menu-toggle" type="button" class="navbar-toggle collapsed borderless-button" data-toggle="collapse" aria-expanded="false" data-target="#navbar" aria-controls="navbar">       
				@if ($currentUser)
					<img class="nav-gravatar" src="{{ $currentUser->present()->gravatar }}" alt="{{ $currentUser->username }}">
					<span class="hidden-xs hidden-sm">{{ $currentUser->firstname }}</span>
				@else
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				@endif
			
			</button>
			
			<?php 
			
			if(Request::is('admin*')){
				$adminState = 'active';
			}else if (Request::is('/','user*','/home')){
				$homeState = 'active';
				$userBannerColor = 'greenBG';
			}else if (Request::is('search/*')){
				$searchState = 'active';
			}else if (Request::is('kjv*','bible*') | isset($versePage)){
				$bibleState = 'active';
			}else {
				$exchangeState = 'active';
			}
			?>
			
             <ul class="nav navbar-nav pull-left">
		          	@if (Auth::check() && Auth::user()->hasRole('admin'))
						<li class="admin {!!$adminState or ''!!}">
							<a href="{!! url('/admin') !!}"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Admin</a>
						</li>
						@endif
						<li class="home {!!$homeState or ''!!}"><a href="{!! url('/') !!}"><span class="glyphicon glyphicon-home" aria-hidden="true" ></span> <span class="hidden-sm hidden-xs"></span>
						@if (Auth::check())						
							@if ($unReadNotifications->count() >= 1)
							<sup class="badge badge-warning">{!! $unReadNotifications->count() !!}</sup>
							@endif
						@endif</a>
						</li>
						<li class="bible {!!$bibleState or ''!!}"><a href="{!! url('/bible') !!}"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> <span class="hidden-sm hidden-xs"></span></a>
						</li>
						<li class="courses {!! $exchangeState or '' !!}"><a href="{!! url('/study') !!}"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> <span class="hidden-sm hidden-xs"></span></a>
						</li>
						
						<li class="search {!! $searchState or '' !!} hidden-xs">{!! $search_form !!}</li>
						
	        	</ul> 
          </div> 
          
          <div id="navbar" class="navbar-collapse collapse">
            <ul id="collapsible-menu" class="nav navbar-nav navbar-right">
					@if ($currentUser)
							<!--not a permanent fix, but this hides the user menu from the nav bar on desktop-->
							<div class="hidden-md hidden-lg hidden-xl">
							<!-- INCLUDE: partials.user-nav-list -->
							@include('partials.user-nav-list')	
							</div>
							<li class="divider"></li>
							<li>{!! link_to_route('logout_path', 'Log Out') !!}</li> 
				    @endif    
					
					@if (!$currentUser)
						<li><a href="{!! route('login_path') !!}"><span class="glyphicon glyphicon-lock"></span> <span>Log In</span></a></li>  
				
				   		<li><a href="{!! route('register_path') !!}"><span class="glyphicon glyphicon-star-empty"></span> <span>Register</span></a></li>
   	@endif
					
            </ul>
          </div><!--/.nav-collapse -->
          
        </div><!--/.container-fluid -->
      </nav>

<!--END NAVIGATION-->