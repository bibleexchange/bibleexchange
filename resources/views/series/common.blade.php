@extends('layouts.default')

@section('be_sub_banner')

<div id="sub_be_banner" class="container-fluid greenBG" >

		<div class="col-md-6">
				<div class="center">
					<small>series</small>
				</div>
			<h2>{{$series->title}}</h2>
			
			<div class="center">
				<h4 style='text-align:center;'>&nbsp;{{$previousAndNext or ""}}</h4>
			</div>
		</div>

		<div class="col-md-6">
		
			<p>{{$series->subtitle}}</p>
			
			@include('partials.social-media')
			
		</div>

</div>
@stop