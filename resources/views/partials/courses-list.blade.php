@foreach($courses->chunk(3) AS $chunk)
<div class="row">

	@foreach($chunk AS $course)
		
		<div class="col-sm-6 col-md-4">
			@include('partials.course-preview')
		</div>
		
	@endforeach
</div>	
@endforeach