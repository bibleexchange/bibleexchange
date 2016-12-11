@extends('layouts.master')

@section('content')

<form style="float:right;">
  PUBLIC? :
<input type="radio" id="public" name="public" value="1" @if ($course->public == 1) checked @endif /> YES
<input type="radio" id="public" name="public" value="0" @if ($course->public == 0) checked @endif /> NOT READY YET
<input type="submit" value="save"/>
</form>

<hr />

</p>
<h1>
  <form>
	<input type="text" name="title" value="{{ $course->title }}" style="width:75%"/>
	<input type="submit" value="save"/>
  </form>
</h1>

<p>
  <form>
	<input type="text" name="bibleverse" value="{{ $course->verse->reference }}" style="width:75%"/>
	<input type="submit" value="save"/>
</form>
</p>

<blockquote>{{ $course->verse->t }}</blockquote>

<p>
DESCRIPTION :
  <form>
	<input type="text" name="description" value="{{ $course->description }}" style="width:75%"/>
	<input type="submit" value="save"/>
  </form>
</p>

<p>

<img src="{{$course->image}}" width="90px"/>

  <form>
    IMAGE:
	<input type="text" name="image" value="{{ $course->image }}" style="width:75%"/>
	<input type="submit" value="save"/>
  </form>
</p>

<hr />

<h2>STEPS</h2>

@foreach($course->steps AS $step)
  <a href={{"/course/" . $course->id . "/" . $step->order_by . "/edit"}}>{{"# " . $step->order_by}}</a>
  last edit: {{$step->updated_at}}
  <hr />
@endforeach

<form>
<input type="submit" value="new step"/>
</form>


@stop

@section('sidebar')

<ul>
  <li>ONE</li>
</ul>

@stop
