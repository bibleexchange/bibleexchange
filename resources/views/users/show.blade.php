@extends('users.public')

@section('window')

    <div class="row">

        <div id="feed" class="col-md-6 col-offset-md-3">

            @if ($user->is($currentUser))
                @include ('notes.partials.publish-scripture-note-form')
            @endif

            @include ('notes.partials.notes', ['notes' => $user->notes])
        </div>
    </div>
    
@stop

@section('scripts')
	<script>@include('notes.partials.note-js')</script>	
@stop