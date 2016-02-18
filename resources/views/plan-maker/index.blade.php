@extends('plan-maker.common')

@section('window')

@include('plan-maker.forms.modal-create')

@include('partials.plans-list',['plans'=>$userPlans)

<center>{!! $userPlans->render() !!}</center>

@stop