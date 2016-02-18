@extends('layouts.user')

@section('window')
	
   @include ('notes.partials.publish-scripture-note-form')
	
   @include ('notes.partials.notes', ['notes' => $notes])

@stop