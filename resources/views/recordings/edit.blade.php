@extends('recordings.common')

@section('window')
	
	<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal">
		delete
	</button>
	
	@include('partials.forms.modal-delete-recording')
	
	<p class="long-description">&nbsp;
	</p>	

<div class="row edit">
	<div class="container">
		<div class="col-md-7">
		
			@include('partials.forms.recording-editor')
			
		</div>
		<div class="col-md-5">	
				@if(Session::has('error'))
				<p class="errors">{{ Session::get('error') }}</p>
				@endif
			
				@include('partials.upload-file',['study'=>$recording])
				<hr>
				@include('partials.edit-recording-extras',['study'=>$recording])	
		</div>
	</div>
</div>
	
	
	
@stop