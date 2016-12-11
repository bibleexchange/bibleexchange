@extends('recordings.common')

@section('window')

<div class="col-sm-12" style="clear:both; margin-bottom:50px;">&nbsp;</div>
	
<center>{!! $recordings->render() !!}</center>

<style>

.thumbnail-be {
	width:200px;
	display:inline-block;
	overflow:hidden;
	float:left;
}
</style>

	@foreach($recordings->chunk(2) AS $chunk)
		
		<div class="row">
			@foreach($chunk AS $recording)
				<div class="col-md-6">
						@include('partials.recording-preview')		
				</div>
			@endforeach
		</div>
	
	@endforeach
	
@stop