@extends('layouts.email')

@section('content')
<h1>Welcome to Bible exchange!</h1>

<p>Your email has been confirmed.</p>

<p> Get <a href='{{{ URL::to("/") }}}'>started</a> in your journey with us in Bible Discovery! </p>

@stop