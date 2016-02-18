@extends('admin.layouts.default')

@section('window')

	<div ng-controller="BookmarksController">
		<table>
			<thead>
			<tr>
				<th>Bookmarks</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="bookmark in bookmarks">
				<td><% bookmark.url %></td>
			</tr>
			</tbody>
		</table>

	</div>

@stop