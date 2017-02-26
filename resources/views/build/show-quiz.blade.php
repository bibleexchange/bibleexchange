@extends('system.plain')

<h1>{{ $quiz->title }}</h1>
<p>Instructions: {{ $quiz->instructions }}</p>

<ul>

  @foreach($quiz->questions AS $que)
  <li>
     <p>{{ $que->body }}</p>
     <p>{!! $que->activity !!}</p>
  </li>
  @endforeach

</ul>
