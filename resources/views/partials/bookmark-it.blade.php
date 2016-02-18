{!! Form::open(['url'=>'/user/bookmarks','style'=>'display:inline-block;']) !!}
	<input type="hidden" name="url" value="{!! Request::url() !!}">
	<button type="submit" value="Next"class="btn btn-default" style="border:none; background:transparent;">
		<span class="glyphicon glyphicon-bookmark"></span>
	</button>
{!! Form::close()!!}