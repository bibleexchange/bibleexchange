@extends('layouts.special-sidebar')

@section('sidebar-main')
	
	<div class="update-image">
		<img src="{!!$study->defaultImage->src!!}" alt="{!!$study->defaultImage->alt_text!!}">
		<button type="button" class="btn btn-default btn-xs update-icon" data-toggle="modal" data-target="#iconModal">
			<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <span class="text">update</span>
		</button>
	</div>
		
	<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#titleModal">
	 change title
	</button>
	
@stop

@section('sidebar-secondary')
	
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
		@include('studies.partials.edit-study-extras')	
		
@stop

@section('main-content')

		<div id="sub_be_banner" class="row greenBG">
			<div class="col-xs-12">
				<h1>
					<a class="pull-left" href="{!! url('/user/course-maker/'.Session::get('last_edited_course_id')) !!}" style="text-decoration: none;">
						<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><sup> last course</sup>
					</a>
					{!! $page->title !!}
				</h1>
			</div>
		</div>
		
		@if(Session::has('error'))
			<p class="errors">{{ Session::get('error') }}</p>
		@endif
		
		<div id="course-maker-content">
			<!-- INCLUDE: studies.forms.edit-article -->
			@include('studies.forms.edit-article')
		</div>

@stop