@extends('user.layout')

@section('window')
<div class="page-header">
    <h1>{{{ Lang::get('user/user.forgot_password') }}}</h1>
</div>
{{ Confide::makeForgotPasswordForm() }}
@stop
