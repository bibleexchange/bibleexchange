@extends('system.plain')

<style>
  aside {
    width:25%;
    float:left;
    overflow-wrap: break-word;
    word-wrap: break-word;
  }

  main {width:65%; float:left;}

</style>

<aside>

<?php
$ev = json_decode($course->everything);
?>

<img src={{$ev->image}} id="course-cover">

<h2>TITLE: {{$ev->title}}</h2>

<p><b>Author:</b> {{$ev->author}}</p>
<p><b>Description:</b> {{$ev->description}}</p>

<p><b>Keywords:</b>

@foreach($ev->keywords AS $k)

{{$k}} &nbsp;

@endforeach
</p>

<h2>Sections: </h2>

<ul>

  @foreach($ev->sections AS $sec)
  <li> {{$sec->title}} ({{count($sec->steps)}} steps)</li>
  @endforeach

</ul>

</aside>

<main>

<h2>Sections: </h2>

<ul>

  @foreach($ev->sections AS $sec)
  <li> {{$sec->title}}
    <ul>
      <?php $x = 1; ?>
      @foreach($sec->steps AS $step)

      <li>Step {{$x}}
        <ul>
        @foreach($step->media AS $media)

          {!! $cb->getMediaHTMLString($media->type, $media->id) !!}
        @endforeach
        </ul>
      </li>
        <?php $x++; ?>
      @endforeach
    </ul>
  </li>
  @endforeach

</ul>
</main>
