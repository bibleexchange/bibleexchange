<center>{!! $images->render() !!}</center>

<style>

.thumbnail-be {
	width:200px;
	display:inline-block;
	overflow:hidden;
	float:left;
}
</style>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
	
	@foreach($images AS $image)
		
		    <div class="thumbnail thumbnail-be">
		     <a data-toggle="collapse" data-target=".image-collapse{{$image->id}}"><img src="{!! $image->src !!}?w=200" title="{!! $image->alt_text!!}">
		     </a>
		      <div class="caption image-collapse{{$image->id}} collapse">
		        <h3>{!! $image->name !!}</h3>
		        <p><a href="{!! $image->verse->url or '' !!}" alt="{!! $image->verse->t or '' !!}">{!! $image->verse->reference or '' !!}</a></p>
		        <p>
		        	<!-- <a href="#" class="btn btn-primary" role="button">Button</a>
		        	 -->
		        @if($session_last_feature)
		         <a data-toggle="collapse" data-target=".use-collapse{{$image->id}}" class="btn btn-default" role="button">Use</a>
		         @endif
		         </p>
		        
		        <span class="use-collapse{{$image->id}} collapse">
		        @if($last_edited_study !== null)          
		          	 {!! Form::open(['url'=>'/gallery','style'=>'width:100%;']) !!}
						<input type="hidden" name="image_id" value="{!!$image->id!!}">
						<input type="hidden" name="study_id" value="{!!$last_edited_study->id!!}">
						<button type="submit" value="Next"class="btn btn-info" >
							<span class="glyphicon glyphicon-copy"></span>for {!!$last_edited_study->present()->title!!}
						</button>
					{!! Form::close()!!}
				@endif
				@if($last_edited_course !== null)  
					{!! Form::open(['url'=>'/gallery','style'=>'width:100%;']) !!}
						<input type="hidden" name="image_id" value="{!!$image->id!!}">
						<input type="hidden" name="course_id" value="{!!$last_edited_course->id!!}">
						<button type="submit" value="Next"class="btn btn-info" >
							<span class="glyphicon glyphicon-copy"></span>for {!!$last_edited_course->present()->title!!}
						</button>
					{!! Form::close()!!}
					
				@else
				
				No options ready right now.
				
		        @endif
		        </span>
		      </div>
		    </div>
		
		
	@endforeach
	</div>
	
</div>
	