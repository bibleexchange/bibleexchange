@foreach ($notes AS $note)
	@include ('notes.partials.note',['note'=>$note])
@endforeach