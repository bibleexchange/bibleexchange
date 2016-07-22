@extends('system.header')

@section('body')
 <div id="main" class="row">
	
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-lg-offset-4 col-md-offset-3">
  
      <div class="logo">
        <h2>Bible Experience</h2>
      </div>
      <div class="wrapper">

        @if($errors->any())
          <ul class="alert alert-danger">
            {{ implode('', $errors->all('<li>:message</li>'))}}
          </ul>
        @endif
  
        @yield('content')
		
      </div>

      <div class="login-options">
        @if( isset($site) && $site->registration === 'Open' )
          <a href="{{ URL::to('/register') }}" class="btn btn-sm btn-primary btn-login-options">{{ trans('site.register') }}</a>
        @endif
        <a href="{{URL::to('/password/reset')}}" class="btn btn-sm btn-default btn-login-options">{{ trans('site.forgotten_pw') }}</a>
      </div>

      <div class="links">
	  Inspired by <a href="http://learninglocker.net">Learning Locker</a>
	  <br />
	  <center>language: ({{App::getLocale()}} )</center>
      </div>

    </div>  
	
  </div>
@stop

@section('scripts')
  {{ HTML::script('assets/js/libs/bootstrap/bootstrap.min.js') }}
  {{ HTML::script('assets/js/respond.min.js') }}
  {{ HTML::script('assets/js/placeholder.js') }}
  
  @yield('scripts')
  
  <script src="/assets/js/smoothstate.js"></script>
  <script src="/assets/js/maintransition.js"></script>
  
@stop