@extends('system.plain')

@section('body')
	
<div style="border-left:yellow 5px solid;border-top:green 5px solid;border-right:red 5px solid;border-bottom:blue 5px solid; height:100%;">
  
      <div style="text-align:center; color:gray; margin-top:10%;">
        <h1>Bible exchange</h1>
	<p>Log in or Register</p>
      </div>

      <div>
  
        @yield('content')
		
      </div>

    </div>  
	
@stop
