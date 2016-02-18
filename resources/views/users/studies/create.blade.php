@extends('users.lessons.common')

@section('window')

@if(isset($lesson) && $lesson !== null)

<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>
		</ul>
	<!-- ./ tabs -->
		
		<?php 
			$edit_lesson_url = '/lessons/'.$lesson->id.'/update';
		?>
		
{!! Form::open(['class'=>'form-horizontal','url'=>$edit_lesson_url,'autocomplete'=>'off']) !!}
	
	{!! Form::hidden('lesson_id',$lesson->id) !!}
	
		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
			<!-- publish -->

				<div class="form-group {!! $errors->has('published') ? 'error' : '' !!}">
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

				<!-- Post Title -->
				<div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Lesson Title</label>
                        
                        {!! Form::text('title',$lesson->title,['class'=>'form-control','name'=>'title','id'=>'title']) !!}
                        
						{!! $errors->first('title', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<!-- ./ post title -->
				
				<!-- Content Type -->
				<div class="form-group {!! $errors->has('content_type') ? 'has-error' : '' !!}">
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
						html: {!! Form::radio('content_format', 'html', $select1) !!}
						markdown: {!! Form::radio('content_format', 'md',$select2) !!}
						{!! $errors->first('content_format', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<!-- ./ Content Type -->
				
				<!-- Content -->
				<div class="form-group {!! $errors->has('content') ? 'has-error' : '' !!}">
					<div class="col-md-12">
                        <label class="control-label" for="content">Content</label>
						<textarea class="form-control full-width {{$content_style or "md"}}" name="content" value="content" rows="23">{{ $lesson->content }}</textarea>
						{!! $errors->first('content', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<!-- ./ content -->
			</div>
			<!-- ./ general tab -->

			<!-- Meta Data tab -->
			<div class="tab-pane" id="tab-meta-data">
				<!-- Meta Title -->
				<div class="form-group {!! $errors->has('meta-title') ? 'error' : '' !!}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-title">Short Title</label>
						<input class="form-control" type="text" name="short_title" id="short_title" value="{{ $lesson->short_title }}" />
						{!! $errors->first('short_title', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<!-- ./ meta title -->

				<!-- Meta Description -->
				<div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="description">Description</label>
						<input class="form-control" type="text" name="description" id="description" value="{{ $lesson->description }}" />
						{!! $errors->first('description', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<!-- ./ meta description -->

				<!-- Meta Keywords -->
				<div class="form-group {!! $errors->has('keywords') ? 'error' : '' !!}">
					<div class="col-md-12">
                        <label class="control-label" for="keywords">Keywords (comma separated)</label>
						<input class="form-control" type="text" name="keywords" id="keywords" value="{{ $lesson->keywords }}" />
						{!! $errors->first('keywords', '<span class="help-block">:message</span>') !!}
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

	@else
		
	<p>No lessons to edit just yet. Why don't you <a href="#select" data-toggle="tab">create</a> one?</p>
	
	@endif

@stop