@extends('layouts.email')

@section('content')

<p>{!! $user['firstname'] !!},</p>

<p>Did you ask to reset your password? If not just ignore this email, but if so just click on the link below. This link will expire within 3 days.</p>

<a href="{!! URL::to('/password/reset/'.$token) !!}">
    {!! URL::to("/password/reset/{$token}") !!}
</a>

@stop