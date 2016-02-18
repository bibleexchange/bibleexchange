@extends('recordings.common')

@section('window')

			<div class="sidebar-block blueBG" style="width:350px; height:200px; margin-top:120px; z-index:999;">
					<span class="study-sharing">
						@include('partials.sharing',[
							'object'=>$recording,
							'twitter_text'=> str_replace(' ','+',$recording->title) . '+by+' . $recording->primaryPerson()->fullname,
							'fb_share_url'=>Request::url(),
							'share_url'=> $recording->shareUrl(),
							'share_title'=>$recording->title,
							'share_media'=>$recording->defaultImage->src,
							'editor_url'=>url('/recordings')
							])
					</span>
			</div>
			
			<p class="long-description"><strong>Preaching: </strong>
				@foreach($recording->preachers AS $preacher)
		     		{!! $preacher->fullname !!} 
		     	@endforeach	
		     	| <strong>dated</strong>: {!! $recording->present()->dated !!}
		     	| <strong>uuid: </strong>: #{!! $recording->id !!}
			</p>
			
	<div class="row" style="clear:both;">
		
		<div class="col-md-5">
			<div class="panel panel-default panel-study-green">
				  <div class="panel-heading">
				    <h2 class="panel-title">Recording Formats ({!! $recording->formats->count() !!})</h2>
				  </div>
				 <div class="panel-body">
			
			     	@include('recordings.partials.recordings-stream',['recording'=>$recording])
					
				</div>
			</div>
		</div>
		
		<div class="col-md-7">
			<div class="panel panel-default panel-study-green">
				  
				  <div class="panel-heading">
				    <h2 class="panel-title">Bible</h2>
				  </div>
				 
				 <div class="panel-body">
					@foreach($recording->verses AS $verse)
		     		 	{!!$verse->quote!!} 
		     		@endforeach
				 </div>
			</div>
		</div>
			
		
		<div class="col-md-4 col-md-of article-panel">
			<div class="panel panel-default panel-study-green">
				  <div class="panel-heading">
				    <h2 class="panel-title">Memo</h2>
				  </div>
				  
				 <div class="panel-body">
					{!! $recording->description !!}	
				</div>
			</div>
		</div>
		
		<div class="col-md-8">
			<div class="panel panel-default panel-study-green">
				  <div class="panel-heading">
				    <h2 class="panel-title">Linked Studies</h2>
				  </div>
				 <div class="panel-body">
			
			     	<span class="pull-right"> 
				     	@foreach($recording->studies AS $study)
				     		@include('studies.partials.study-preview')
				     	@endforeach
			     	</span>

				</div>
			</div>
		</div>

	</div>

@stop