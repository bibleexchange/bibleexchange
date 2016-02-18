		<!--If User is Logged in then-->
		@if($currentUser)
		
		@media(min-width:768px){
		
			.navbar-header {
				display:block;
				width:100%;
			}
			
			.navbar-header:before, .navbar-header:after {
				content: " ";
				display: table;
			}
			
			#navbar .nav > li {
				width:100%;
			}
		
		}
		<!--Otherwise, do this instead-->
		@else
		

			

			
		@media(max-width:768px){


			
		}
		
		@endif