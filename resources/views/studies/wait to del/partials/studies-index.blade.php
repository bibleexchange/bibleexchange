@foreach($studies->chunk(2) AS $chunk)

	<div class="row">
		@foreach($chunk AS $s)
			<div class="col-md-6">
				<!-- INCLUDE: studies.partials.study-preview -->
				@include('studies.partials.study-preview',['study'=>$s])
			</div>
		@endforeach
	</div>

@endforeach