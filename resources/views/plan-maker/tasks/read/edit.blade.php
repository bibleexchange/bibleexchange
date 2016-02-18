@extends('course-maker.common-task')

@section('task-template')

	@include('course-maker.forms.attach-task-study',['task'=>$task])
	
	@foreach($task->model->properties AS $study)
	<?php $study = $study->getObject(); ?>
	 	@include('partials.study-preview',['study'=>$study])
	@endforeach
	
	
@stop