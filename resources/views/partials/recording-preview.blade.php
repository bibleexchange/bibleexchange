    <div class="thumbnail">
    	
     <a data-toggle="collapse" data-target=".image-collapse{{$recording->id}}">
     	<p><span class="glyphicon glyphicon-plus"></span> 
     		{!! $recording->title !!}
     		
     		@if (isset($recording->verses))
     			[{!!$recording->verses->first()->reference!!}] 
     		@endif
     		
     		@foreach($recording->preachers AS $preacher)
     			{!! $preacher->fullname !!} 
     		@endforeach
	     	
	     	<span class="pull-right"><strong>formats</strong>: 
		     	@foreach($recording->formats AS $format)
		     		[{!! $format->format !!}] 
		     	@endforeach
	     	</span>
    
     	</p>
     </a>
      <div class="caption image-collapse{{$recording->id}} collapse">
        <h3>{!! $recording->name !!}</h3>
        <p><a href="{!! $recording->verse->url or '' !!}" alt="{!! $recording->verse->t or '' !!}">{!! $recording->verse->reference or '' !!}</a></p>
        <p><a href="{!! $recording->url() !!}" class="btn btn-primary" role="button">Go To</a>
        
        @if($session_last_feature)
         <a data-toggle="collapse" data-target=".use-collapse{{$recording->id}}" class="btn btn-default" role="button">Use</a>
         @endif
         </p>
        
        <span class="use-collapse{{$recording->id}} collapse">
        @if($session_last_course)          
          	 {!! Form::open(['route'=>'recording-to-study']) !!}
				<input type="hidden" name="recording_id" value="{!!$recording->id!!}">
				<input type="hidden" name="study_id" value="{!!$session_last_course->id!!}">
				<button type="submit" value="Next"class="btn btn-info" >
					<span class="glyphicon glyphicon-copy"></span>add to {!!$session_last_course->present()->title!!}
				</button>
			{!! Form::close()!!}
		@else
		
		No options ready right now.
		
        @endif
        </span>
      </div>
    </div>