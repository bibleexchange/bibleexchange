@extends('layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ String::title('series') }}} ::
@parent
@stop

@section('be_sub_banner')
		
	<div id="sub_be_banner" class="container-fluid greenBG" >
		<div class="col-md-6">
			<h2>Series</h2>
		</div>
		<div class="center">
		<div class="col-md-6">
			<p>Study a collection of Bible-related lessons.</p>
		</div>
		</div>
	</div>
@stop

{{-- Content --}}
@section('content')

<div class ="row">
	<table>
			@include('partials.tiles')
	</table>
</div>
<center>{{ $series->links() }}</center>

@stop
