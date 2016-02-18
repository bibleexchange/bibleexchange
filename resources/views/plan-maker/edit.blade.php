@extends('course-maker.common')

@section('window')

<div class="row">
	
	<div class="col-sm-3 col-md-2 update-image">
		<img src="{!!$course->defaultImage->src!!}" alt="{!!$course->defaultImage->alt!!}">
		<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#updateImageModal">
		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <span class="text">update</span>
		</button>
	</div>
	
	<div class="col-sm-9 col-md-10">
		@include('course-maker.forms.edit')
	</div>
	
	<div class="col-sm-9 col-md-10">
		@include('course-maker.forms.modal-create-section')
	</div>
	
</div>

<div class="row">	
	<div class="col-sm-8 col-sm-offset-2">
		<ul>
		@foreach($course->sections AS $section)
			<li>
				<a data-toggle="collapse" data-target="#collapse{!!$section->id!!}" href="#collapseOne"> 				
					<h2>Section {!! $section->orderBy!!}: {!! $section->title !!}</h2>
					<span class="caret pull-right"></span>
				</a>
				
				@include('course-maker.forms.modal-create-task')
				
				<span id="collapse{!!$section->id!!}" class="collapse">
					@include('course-maker.forms.edit-section')
				</span>	
				
				<ul>
					@foreach($section->tasks AS $task)
						<li>
							<a data-toggle="collapse" data-target="#collapse{!!$task->id!!}" >
								<p><span class="glyphicon glyphicon-task-type-{!!$task->task_type_id!!}"></span>
								 {!!$task->title!!}</p>
							</a>
							<span id="collapse{!!$task->id!!}" class="collapse">
								@include('course-maker.forms.edit-task')
								
								<a class="btn btn-link btn-sm pull-right" 
								href="/user/course-maker/{!!$course->uuid!!}/section/{!!$section->id!!}/task/{!!$task->id!!}/edit">editor</a>
							</span>
						</li>
					@endforeach
				</ul>
				
			</li>
		@endforeach
		</ol>
	</div>
	
</div>

<!-- Modals -->
@include('course-maker.forms.modal-update-image')

@stop