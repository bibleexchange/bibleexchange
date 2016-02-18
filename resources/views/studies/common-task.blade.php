@extends('layouts.default')

@section('be_sub_banner')

<div id="course-maker-content" class="row">
	<div class="container-fluid">

		<div id="sub_be_banner" class="row greenBG">
			<div class="col-xs-12">
				<h1>
						<a class="pull-left" href="{!!$study->editUrl()!!}">
							<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
						</a>
					@if(isset($task->model))
						<span class="glyphicon glyphicon-task-type-{!!$task->model->task_type_id!!}" aria-hidden="true"></span>
						{{$task->model->taskType->name}}
					@endif
					{!! $page->title !!}
				</h1>
			</div>
		</div>
	
	</div>
</div>

@stop

@section('content')

	@yield('task-template')

@stop