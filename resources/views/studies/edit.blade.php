@extends('studies.common')

@section('window')

<div class="row create">
	<div class="container">
	<div class="col-md-8 col-md-offset-2">
		
		<a href="{{$study->url()}}">{{$study->title}}</a>
		
		
		<div class="update-image">
		<img src="{!!$study->defaultImage->src!!}" alt="{!!$study->defaultImage->alt_text!!}">
		<button type="button" class="btn btn-default btn-xs update-icon" data-toggle="modal" data-target="#iconModal">
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <span class="text">update</span>
		</button>
	</div>
		
	<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#titleModal">
	 change title
	</button>
		
		
		
		
		
		<a class="btn btn-default btn-xs" href="{!!$study->previewUrl()!!}"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> preview</a>			
		<a class="btn btn-default btn-xs" href="{!!$study->url()!!}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view public</a>
		
		<!--  include('studies.forms.modal-create-task')  -->
		
		<!-- INCLUDE: studies.forms.public-private-study -->
		@include('studies.forms.public-private-study')
		
		@if($study->isPublished())
			<a class="btn btn-default btn-xs all-published" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> all changes have been published</a>
		@else
			<!-- INCLUDE: studies.forms.publish-study -->
			@include('studies.forms.publish-study')
		@endif
			
		@include('studies.partials.upload-file')
		<hr>
		
		
		
		
		
		@include('studies.forms.study-editor')
	
		@if(Session::has('error'))
		<p class="errors">{{ Session::get('error') }}</p>
		@endif
	
	@include('studies.partials.upload-file')
	
	@include('studies.partials.edit-study-extras')	
	
	<hr>
		@include('studies.partials.article-tips')
	</div>
	</div>
</div>
	
@stop

@section('scripts')

	@parent

	@include('studies.partials.study-editor-js')

@stop