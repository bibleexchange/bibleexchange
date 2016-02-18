@extends('course-maker.common')

@section('window')

@include('course-maker.forms.modal-create')

@include('partials.courses-list',['courses'=>$userCourses])

<center>{!! $userCourses->render() !!}</center>

@stop