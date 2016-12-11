{!! $recording->title !!}
     
@foreach($recording->formats AS $format)
		
	@if($format->format === 'soundcloud-mp3' || $format->format === 'soundcloud-m4a')

	<button class="btn btn-default btn-xs" style="display:inline; background-color:transparent;"" data-toggle="collapse" data-target="#sc{!!$recording->id!!}">{!!$format->format!!}</button>
	
	<div id="sc{!!$recording->id!!}" class="collapse">
     {!! $format->stream !!} <span class="pull-right">{!! $format->download !!}</span>
	</div>
     
   @else
   
   	<button data-toggle="modal" data-target="#myModal{!!$format->id!!}">{!!$format->format!!}</button>
    
    <div class="modal fade" id="myModal{!!$format->id!!}" tabindex="-1"	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">{!! $format->format !!}</h4>
				</div>
				<div class="modal-body">
					{!! $format->stream !!}
				</div>
				<div class="modal-footer">
					
					<button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
					
				</div>
			</div>
		</div>
	</div>
   @endif
     		
@endforeach
   
<hr>