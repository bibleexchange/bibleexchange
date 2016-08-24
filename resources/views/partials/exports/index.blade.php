@extends('layouts.master')

@section('head')
  @parent
  <script>
    window.lrs = {
      key: '{{ $client->api_basic_key}}',
      secret: '{{ $client->api_basic_secret }}'
    };
  </script>
  {{ HTML::style('assets/css/exports.css')}}
  {{ HTML::style('assets/css/typeahead.css')}}
@stop

@section('sidebar')
  @include('partials.lrs.sidebars.lrs')
@stop

@section('content')

  <div class="page-header">
    <h1>{{ Lang::get('exporting.title') }}</h1>
  </div>

  <div id="content"></div>

  <script data-main="{{ URL::to('/assets/js/exports/config') }}" src="{{ URL::to('/assets/js/libs/require/require.js') }}"></script>
    <script>
  require.config({
    urlArgs: "bust=" + (new Date()).getTime()
  });
  
  </script>
@stop
