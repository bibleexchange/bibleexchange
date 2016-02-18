@extends('users.public')

@section('window')

@include('partials.courses-list',['courses'=>$courses])

<center>{!! $courses->render() !!}</center>

@stop