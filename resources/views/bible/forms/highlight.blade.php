{!! Form::open(['route'=>'highlight_verse','class'=>'form-inline']) !!}
	
	{!! Form::hidden('bible_verse_id','') !!}
	Highlight: 
	<div class="form-group">
	@foreach($highlight_colors AS $color)
		
		{!! Form::radio('color',$color['id'],null,['id'=>$color['id']]) !!}

		<label for="{{$color['id']}}" class="bible-highlight" style="border-color:{{$color['strong']}}; background-color:{{$color['subtle']}};">
			{{$color['category']}}
		</label>
		
	@endforeach
	
	{!! Form::submit() !!}
	</div>
{!! Form::close() !!}