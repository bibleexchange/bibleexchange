@foreach ($amens AS $amen)
	@include ('amens.amen',['object'=>$amen->getObject()])
@endforeach