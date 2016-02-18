@extends('studies.common-task')

@section('task-template')
<h2>Questions for "{!!$study->present()->title!!}" {!!$task->model->title!!}</h2>
<ol>
	@foreach($task->model->questions AS $question)
	
		<li>@include('studies.forms.update-question')</li>

	@endforeach
	
	<li>@include('studies.forms.create-question')</li>
</ol>
	
	
@stop