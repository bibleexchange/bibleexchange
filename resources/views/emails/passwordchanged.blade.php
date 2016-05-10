@extends('layouts.email')

@section('content')

<p>{!! $user['firstname'] !!},</p>

<p>Your password was updated successfully.</p>

<p>If you didn't authorize this change, please let us know. 

<a href="mailto:be@deliverance.me?Subject=password_was_illegally_changed" target="_top">
be@deliverance.me</a>
</p>

@stop