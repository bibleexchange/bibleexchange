@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>
		</ul>
	<!-- ./ tabs -->

	{{-- Edit Blog Form --}}
	<form class="form-horizontal" method="post" action="{{$form->action or ""}}" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
			<!-- publish -->
			@if (isset($lesson))
				<div class="form-group {{{ $errors->has('published') ? 'error' : '' }}}">
					<div class="col-md-12" style="text-align:right;">
                        <label class="control-label" for="published">Published?</label>						
						
						
						<?php 					
						if($lesson->published === 1)
						{
								$publishedTrueFalse = 'YES';	
						}else{
							$publishedTrueFalse = 'NO';
						}
						?>
							{{$publishedTrueFalse}}<a href="{{$form->publish or ""}}"> (change)</a>
						
					</div>
				</div>
			<!-- ./publish -->
			@endif
				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Lesson Title</label>
						<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($lesson) ? $lesson->title : null) }}}" />
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ post title -->
				
				<!-- Content Type -->
				<div class="form-group {{{ $errors->has('content_type') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="content-type">Format</label>
						@if(isset($lesson))
						<?php 					
						switch($lesson->content_format)
						{
							case 'md':
								$select1 = false;
								$select2 = true;
								break;
							default:
								$select1 = true;
								$select2 = false;
						}
						
						?>	
						@else
						<?php
								$select1 = false;
								$select2 = true;
						?>
						@endif
						html: {{ Form::radio('content_format', 'html', $select1) }}
						markdown: {{ Form::radio('content_format', 'md',$select2) }}
						{{ $errors->first('content_format', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ Content Type -->
				
				<!-- Content -->
				<div class="form-group {{{ $errors->has('content') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="content">Content</label>
						<textarea class="form-control full-width {{$content_style or "md"}}" name="content" value="content" rows="45">{{{ Input::old('content', isset($lesson) ? $lesson->content : null) }}}</textarea>
						{{ $errors->first('content', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ content -->
			</div>
			<!-- ./ general tab -->

			<!-- Meta Data tab -->
			<div class="tab-pane" id="tab-meta-data">
				<!-- Meta Title -->
				<div class="form-group {{{ $errors->has('meta-title') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-title">Meta Title</label>
						<input class="form-control" type="text" name="meta-title" id="meta-title" value="{{{ Input::old('meta-title', isset($lesson) ? $lesson->meta_title : null) }}}" />
						{{ $errors->first('meta-title', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ meta title -->

				<!-- Meta Description -->
				<div class="form-group {{{ $errors->has('meta-description') ? 'error' : '' }}}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="meta-description">Meta Description</label>
						<input class="form-control" type="text" name="meta-description" id="meta-description" value="{{{ Input::old('meta-description', isset($lesson) ? $lesson->meta_description : null) }}}" />
						{{ $errors->first('meta-description', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ meta description -->

				<!-- Meta Keywords -->
				<div class="form-group {{{ $errors->has('meta-keywords') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-keywords">Meta Keywords</label>
						<input class="form-control" type="text" name="meta-keywords" id="meta-keywords" value="{{{ Input::old('meta-keywords', isset($lesson) ? $lesson->meta_keywords : null) }}}" />
						{{ $errors->first('meta-keywords', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ meta keywords -->
			</div>
			<!-- ./ meta data tab -->			
		</div>
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
