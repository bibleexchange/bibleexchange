@extends('layouts.default')

@section('be_sub_banner')

<div id="course-maker-content" class="row">
	<div class="container-fluid">

		<div id="sub_be_banner" class="row redBG">
			<div class="col-xs-12">
				<h1>
					<a class="pull-left" href="{!!url($study->url())!!}">
							<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
						</a>
					Test: {!! $page->title !!}
				</h1>
			</div>
		</div>
	
	</div>
</div>

@stop

@section('content')
	<br>
	<div class="progress">
	  <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="{!!$progress!!}" aria-valuemin="0" aria-valuemax="100" style="width:{!!$progress!!}%; min-width:30px;">
	    <span class="">{!!$progress!!}% Complete</span>
	  </div>
	</div>
	
	@include('partials.forms.test',['questions'=>$study->questions])

@stop