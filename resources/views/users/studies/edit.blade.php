@extends('users.lessons.common')

@section('window')

<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-meta-data" data-toggle="tab">Meta data</a></li>
			<li><a href="#tab-resources" data-toggle="tab">Resources</a></li>
		</ul>
	<!-- ./ tabs -->
		
		<?php 
			$edit_lesson_url = '/lessons/'.$lesson->id.'/update';
		?>
		
{!! Form::open(['id'=>'editlesson','class'=>'form-horizontal','url'=>'/user/lessons/'.$lesson->id.'/update','autocomplete'=>'off']) !!}
	
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
						if($lesson->published == 1)
						{
							$publishedTrueFalse = 'YES';	
						}else{
							$publishedTrueFalse = 'NO';
						}
						?>
							{{$publishedTrueFalse}}<a href="/user/lessons/{{$lesson->id}}/publish"> (change)</a>
						
					</div>
				</div>
			<!-- ./publish -->
				
				<div class="form-group {!! $errors->has('course_id') ? 'error' : '' !!}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Course</label>
                        
                        {!! Form::select('course_id',[null => 'select course'] + $all_courses,$lesson->course_id,['class'=>'form-control','name'=>'course_id','id'=>'course_id']) !!}
                        
						{!! $errors->first('course_id', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				
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
					<div class="col-sm-6">
                        <label class="control-label" for="content">Content</label>
						<textarea class="form-control full-width {{$content_style or "md"}}" name="content" value="content" rows="23">{{ $lesson->content }}</textarea>
						{!! $errors->first('content', '<span class="help-block">:message</span>') !!}
					</div>
					<div class="col-sm-6">
						<label class="control-label" for="content"><a href="{{$lesson->defaultUrl}}">Preview</a></label>
						<article class="textbook">{!! nl2br(Markdown::convertToHtml($lesson->content)) !!}</article>
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
			
			<!-- Resources Data tab -->
			<div class="tab-pane" id="tab-resources">
				<!-- Resources Audio -->
				<div class="form-group {!! $errors->has('audio') ? 'error' : '' !!}">
					<div class="col-md-12">
                        <label class="control-label" for="audio">Add Audio: </label>
						
                        {!! Form::select('audio',array('default' => 'lesson audio?') + $audios, 'default') !!}
                        
						{!! $errors->first('audio', '<span style="color:red;">:message</span>') !!}
					</div>
				</div>
				<!-- ./ Resources Audio -->
				
				<!-- Resources Bible Verse -->
				<div class="form-group {!! $errors->has('bible_verse_id') ? 'error' : '' !!}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="bible_verse_id">Bible Verse</label>
						<input class="form-control" type="text" name="bible_verse_id" id="bible_verse_id" value="{{ $lesson->verse->reference or "NULL" }}" />
						{!! $errors->first('bible_verse_id', '<span class="help-block">:message</span>') !!}
					</div>
				</div>
				<!-- ./ resources bible verse -->

			</div>
			<!-- ./ Resources Data tab -->			
				
		</div>
		<!-- ./ tabs content -->

		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-12">
				<element class="btn-cancel close_popup">Cancel</element>
				<button type="reset" class="btn btn-default">Reset</button>
				<button id="savelesson" type="submit" class="btn btn-success">Update</button> (CTRL+S or CMD+S)
			</div>
		</div>
		<!-- ./ form actions -->
	</form>

	@foreach($lesson->audios AS $audio)
	<?php 
		$url = '/user/lessons/'.$lesson->id.'/audios/'.$audio->id.'/detach';
	?>
		{!! Form::open(['url'=>$url]) !!}
			{!! Form::label('audio',$audio->description) !!}
			{!! Form::submit('delete',['class'=>'btn btn-danger']) !!}						
		{!! Form::close() !!}
	@endforeach
	
@stop

@section('scripts')

@parent
<script>
	$(window).bind('keydown', function(event) {
	    if (event.ctrlKey || event.metaKey) {
	        switch (String.fromCharCode(event.which).toLowerCase()) {
	        case 's':
	            event.preventDefault();
	            $('form#editlesson').submit();
	            break;
	        case 'f':
	            event.preventDefault();
	            alert('ctrl-f');
	            break;
	        case 'g':
	            event.preventDefault();
	            alert('ctrl-g');
	            break;
	        }
	    }
	});
</script>

@stop