@extends('studies.common')

@section('window')

@if($currentUser)
	
	<span class="pull-right">
		{!!Form::open(['route'=>'go_to_study','id'=>'go-to-study'])!!}
			{!! Form::text('query') !!}
			{!! Form::submit('study it!',['class'=>'btn btn-warning']) !!}
		{!!Form::close()!!}
	</span>
	
	<p style="float:left; padding-top:15px;">	
		Would you like to start your own  study on <a href="{!! url('user/study-maker/'.$study->present()->urlTitle).'/create'!!}">{!!$study->present()->title!!}</a>?
	</p>

@endif
<hr style="clear:both;">

@if(count($similarStudies) >= 1)

		<h2>({!!$similarStudies->total()!!}) Maybe some of these will help?:</h2>
		
		<center>{!! $similarStudies->render() !!}</center>
		<div class="row">
			
			@foreach($similarStudies AS $s)
			
			<div class="col-md-6">
				@include('studies.partials.study-preview',['study'=>$s])
			</div>

			@endforeach
		</div>
	@endif
@stop