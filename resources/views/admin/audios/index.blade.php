@extends('admin.layout')

@section('window')
	<div class="page-header">
		<h3>
			Audio Management
!! INCOMPLETE submitting form will break or do nothing.
		</h3>
	</div>
	
	<ul>
		{!! $errors->first('date', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('title', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('bible', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('theme', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('download_url', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('host', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('genre', '<li style=\'color:red;\'>*:message</li>') !!}
		{!! $errors->first('memo', '<li style=\'color:red;\'>*:message</li>') !!}
	</ul>
	
	<table id="users" class="table table-striped table-hover">
		
			<tr>
			{!! Form::open() !!}
				<td>{!!Form::submit('create', array('class' => 'btn btn-success')) !!}</td>
				<td>{!! Form::text('date', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('title', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('bible', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('theme', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('download url', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('host', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('genre', NULL, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('memo', NULL, array('class' => 'form-control')) !!}</td>
			{!! Form::close() !!}
			</tr>
		
		<thead>
			<tr>
				<th class="col-md-2"></th>
				<th class="col-md-2"> Unique Key </th>
				<th class="col-md-2"> Title </th>
				<th class="col-md-2"> bible </th>
				<th class="col-md-2"> theme </th>
				<th class="col-md-2"> download url </th>
				<th class="col-md-2"> host </th>
				<th class="col-md-2"> genre </th>
				<th class="col-md-2"> memo </th>
			</tr>
		</thead>
		<tbody>
		
		@foreach($audios as $audio)
		
			<tr>
			{!! Form::open(['url'=>URL::to('admin/audios/'.$audio->id.'/update')]) !!}
				<td>
					{!!Form::submit('update', array('class' => 'btn btn-primary')) !!}
				</td>
				<td>{!! Form::text('date', $audio->date, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('title', $audio->title, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('bible', $audio->bible, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('theme, $audio->theme, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('download url', $audio->download, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('host', $audio->host, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('genre', $audio->genre, array('class' => 'form-control')) !!}</td>
				<td>{!! Form::text('memo', $audio->memo, array('class' => 'form-control')) !!}</td>
			{!! Form::close() !!}
			</tr>
		@endforeach
		</tbody>
	</table>
@stop