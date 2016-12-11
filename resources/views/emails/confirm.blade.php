@extends('layouts.email')

@section('content')

<h1>Please Confirm Your Email for Bible exchange</h1>

<p>Thanks for registering! Please confirm your email by clicking the link below.</p>

<p>
<a href='{!! URL::to("/register/{$confirmation_code}") !!}'>
    {!! URL::to("/register/{$confirmation_code}") !!}
</a>
</p>

<p>P.S. <br>
If the link isn't working just copy and paste the address into your browser.
</p>

@stop