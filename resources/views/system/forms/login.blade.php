@extends('layouts.loggedout')

@section('content')

  @if(Session::has('success'))
    <div class="clearfix">
      <div class="alert alert-info">
        {{ Lang::get('reminders.reset') }}
      </div>
    </div>
  @endif

<div id="register-app" data={{$register_data->all()}} >
  <h1 class="col-sm-10 col-sm-offset-2">{{ trans('site.login') }}</h1>

  {{ Form::open(array('url' => '/login', 'class' => 'form-horizontal')) }}

    <div class="form-group">
      {{ Form::label('email', 'Email', array('class' => 'col-sm-2 control-label')) }}
      <div class="col-sm-10">
        {{ Form::text('email','',array('class' => 'form-control')) }}
      </div>
    </div>

    <div class="form-group">
      {{ Form::label('password', 'Password', array('class' => 'col-sm-2 control-label')) }}
      <div class="col-sm-10">
        {{ Form::password('password',array('class' => 'form-control')) }}
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-10 col-lg-offset-2">
        {{ Form::submit('Submit',array('class' => 'btn btn-primary')) }}
      </div>
    </div>

  {{ Form::close() }}
</div>

<hr>

  <a class="btn btn-block btn-social btn-github" href="/auth/github">

<svg aria-hidden="true" class="octicon octicon-mark-github" height="24" version="1.1" viewBox="0 0 16 16" width="24"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg>Sign in with Github
  </a>

<hr>

<h4><a href={{URL::to('/register')}}>Register instead?</a></h4>

@stop

@section('scripts')
@parent
<script type="text/babel" src="scripts/RegisterApp.js"></script>
@stop	