<div class="row">&nbsp;</div>

@foreach($studies AS $s)
	<div class="row">
	<!-- INCLUDE: studies.partials.study-preview -->
	@include('studies.partials.study-preview',['study'=>$s])
	</div>
@endforeach