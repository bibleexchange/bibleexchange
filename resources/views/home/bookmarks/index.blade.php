@extends('layouts.user')

@section('window')

	<div ng-controller="BookmarksController">
		<center><h1>Bookmarks</h1></center>
		<center><input type="text" placeholder="filter" ng-model="search" style="width:175px; display:inline-block;"></center>
		<hr>	
			<div ng-repeat="bookmark in bookmarks | filter:search">
				<a href="/user/bookmarks/<% bookmark.id %>/delete" type="button" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-remove"></span></a>
				<a href="<% bookmark.url %>" ><% bookmark.url %></a>
				<hr>		
			</div>
			

	</div>
	
@stop