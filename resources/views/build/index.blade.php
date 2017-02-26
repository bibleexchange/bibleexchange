@extends('system.plain')


<h1>Courses Available for Editing</h1>

@foreach($courses AS $course)

  <li><a href={{"/build-my-course/" . $course->name . "/publish"}}>{{$course->title}} by {{$course->author}}</li>

@endforeach
