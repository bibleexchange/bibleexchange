@extends('recordings.common')

@section('window')
<h3>&nbsp;</h3>
<p style="margin-left:200px;">No members have entered this recording, yet.

@if($currentUser && $currentUser->hasRole('be_editor'))
	Why don't you <a href="{!! url('recording/create/'.$recording->present()->urlTitle)!!}">start</a>?
@endif

</p>
<hr>

@if(count($similarRecordings) >= 1)

		<h2>({!!$similarRecordings->total()!!}) Maybe some of these will help?:</h2>
		
		<center>{!! $similarRecordings->render() !!}</center>
		<div class="row">
			
			@foreach($similarRecordings AS $s)
			<div class="col-md-4">
				@include('partials.recording-preview',['recording'=>$s])
			</div>
			@endforeach
		</div>
	@endif
@stop