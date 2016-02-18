@extends('layouts.user')

@section('content')

<div id="course-maker-content" class="row">
	<div class="container-fluid">

		<div id="sub_be_banner" class="row greenBG">
			<div class="col-xs-12">
				<h1>
					@if(isset($task->model))
						<a class="pull-left" href="{!!url('/user/course-maker/'.$course->uuid)!!}">
							<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
						</a>
						<span class="glyphicon glyphicon-task-type-{!!$task->model->task_type_id!!}" aria-hidden="true"></span>
						{{$task->model->taskType->name}}
					@endif
					{!! $page->title !!}
				</h1>
			</div>
		</div>

		@yield('window')
	
	</div>
</div>

@stop