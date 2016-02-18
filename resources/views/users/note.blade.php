@extends('users.public')

@section('window')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            
        	<blockquote>{!! $notes[0]->verse->getQuoteAttribute()!!}</blockquote>
        
            @include ('notes.partials.notes-php', ['notes' => $notes])
        </div>
    </div>
    
@stop