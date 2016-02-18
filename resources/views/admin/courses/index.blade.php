@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

@section('keywords')Courses administration @stop
@section('author') @stop
@section('description')Courses administration index @stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}

			<div class="pull-right">
				<a href="{{{ URL::to('admin/exchangecreate') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="courses" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-4">Title</th>
				<th class="col-md-2">Subtitle</th>
				<th class="col-md-2">Open?</th>
				<th class="col-md-2">Ready?</th>
				<th class="col-md-2">Public?</th>
				<th class="col-md-2">Created</th>
				<th class="col-md-2">Updated</th>
				<th class="col-md-2">Articles</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
				
			</tr>
		</thead>
		<tbody>
		

		
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			oTable = $('#courses').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/exchangedata') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop