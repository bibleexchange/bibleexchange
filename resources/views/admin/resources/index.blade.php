@extends('admin.layout')

@section('window')
	<div class="page-header">
		<h3>
			{!! $title !!}

			<div class="pull-right">
				<a href="{!! URL::to('admin/'.$modelTable.'/create') !!}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="{!! $modelTable !!}" class="table table-striped table-hover">
		<thead>
			<tr>	
			@foreach($tableHeaders as $header)
				<th class="col-md-2">{{$header}}</th>
			@endforeach
				<th class="col-md-2">actions</th>
			</tr>
		</thead>
		<tbody>
			@foreach($model as $m)
			<tr>
				@foreach($tableHeaders AS $h)
				<td class="col-md-2">{{$m->$h}}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>
@stop