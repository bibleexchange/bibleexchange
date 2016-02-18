@foreach($plans->chunk(3) AS $chunk)
<div class="row">

	@foreach($chunk AS $plan)
		
		<div class="col-md-4">
			@include('partials.plan-preview')
		</div>
		
	@endforeach
</div>	
@endforeach