@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
			<li><a href="#tab-meta-data" data-toggle="tab">Extra</a></li>
		</ul>
	<!-- ./ tabs -->

	{{-- Edit Blog Form --}}
	<form class="form-horizontal" method="post" action="@if (isset($course)){{ URL::to('admin/exchange' . $course->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- Post Title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Course Title</label>
						<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($course) ? $course->title : null) }}}" />
						{{ $errors->first('title', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ post title -->

				<!-- Subtitle -->
				<div class="form-group {{{ $errors->has('subtitle') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="subtitle">Subtitle</label>
						<input class="form-control" type="text" name="subtitle" value="{{{ Input::old('subtitle', isset($course) ? $course->subtitle : null) }}}" />
						{{ $errors->first('subtitle', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ subtitle -->
				<!-- shortname -->
				<div class="form-group {{{ $errors->has('shortname') ? 'has-error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="subtitle">Short Name</label>
						<input class="form-control" type="text" name="shortname" value="{{{ Input::old('shortname', isset($course) ? $course->shortname : null) }}}" />
						{{ $errors->first('shortname', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ shortname -->
			</div>
			<!-- ./ general tab -->
         <?php 
            $extras = ['year','acceptingEnroll','webReady','public'];
			?>
			<!-- Meta Data tab -->
			<div class="tab-pane" id="tab-meta-data">
				
				@foreach($extras AS $c)
				<!-- Meta {{$c}} -->
				<div class="form-group {{{ $errors->has($c) ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="year">{{$c}}</label>
						<input class="form-control" type="text" name="{{$c}}" id="{{$c}}" value="{{{ Input::old($c, isset($course) ? $course->$c : null) }}}" />
						{{ $errors->first($c, '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- ./ meta {{$c}} -->
			@endforeach
			
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
