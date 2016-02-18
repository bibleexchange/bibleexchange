@extends('studies.common')

@section('window')
		
	<div class="row" style="clear:both;">
		<div class="col-md-3">
			<div class="sidebar">
				<img class="study-default-image" src="{{$page->mainImage->src}}" name="{{$page->mainImage->name}}" alt="{{$page->mainImage->alt_text}}">	
				@if($currentUser && $study->isCreator($currentUser))
					<a href="{!!$study->editUrl()!!}">
						<div class="sidebar-block redBG">
							<h2><span class="glyphicon glyphicon-edit" aria-hidden="false"></span> Edit</h2>
						</div>
					</a>
				@endif		
				<div class="sidebar-block orangeBG">
					<h2>Author</h2>
					<p> 
						@include ('users.partials.avatar', ['size' => 25,'user'=>$study->creator])
						<a>
							{{$study->creator->fullname}}
						</a> 				
					</p>
					<p class="small">
						Edited by
							@foreach($study->editors() As $editor)
								<a href="{{$editor->profileURL()}}">
								{{$editor->fullname}}
								</a> 
							@endforeach		
					</p>
				</div>
				<div id="sidebar-collapse" class="collapse">
					<div class="sidebar-block blueBG">
						<h2><span class="glyphicon glyphicon-time" aria-hidden="true"></span></h2>
						<p>
							@if( $study->present()->lastChangeWasMade !== NULL)
								Updated {!! $study->present()->lastChangeWasMade !!}
							@endif
						</p>
						<p class="small">
							Created {!! $study->present()->created_at !!}
						</p>
					</div>
					<div class="sidebar-block greenBG">
						<h2>Share</h2>
						<span class="study-sharing">				
							@if( ! isset($creating))					
								@include('partials.sharing',[
							 		'twitter_text'=> 'Check out this study+by+' . $study->creator->url,
							 		'object'=>$study,
							 		'fb_share_url'=>$study->url(),
							 		'share_url'=>$study->url(),
							 		'share_title'=>$study->title,
							 		'share_media'=>$study->defaultImage->src,
							 		'editor_url'=>$study->creator->url
							 		])
							@endif			
						</span>
					</div>
					@if($study->recordings->count() >= 1)
						<div class="sidebar-block blueBG">
					    	<h2 class="">Media</h2>
							@foreach ($study->recordings AS $recording)
								@include('recordings.partials.recordings-stream-minimal',['recording'=>$recording])
							@endforeach
						</div>
					@endif
		
					@if($study->tags->count() >= 1)
						<div class="sidebar-block greenBG">
							<h2>Tags</h2>
							<p> 
							@foreach($study->tags AS $tag)
								<a href="/tag/{!! $tag->name!!}">{!! $tag->name !!}</a>
							@endforeach
							</p>
						</div>
					@endif
				</div><!--End sidebar-collapse-->
				<a class="hidden-sm hidden-md hidden-lg" data-toggle="collapse" href="#sidebar-collapse" aria-expanded="false" aria-controls="collapseExample">
					<div class="sidebar-block greenBG">
						<h2><span class="glyphicon glyphicon-menu-down" aria-hidden="true"></h2>
					</div>
				</a>
			</div><!--End sidebar-->
		</div>

		<div class="col-md-9">
			<div class="textbook">		  
				@include('studies.partials.study')	
			</div>			 	
			<div class="panel panel-default panel-study-green">
			  	<div class="panel-heading">
			    	<h2 class="panel-title">Comments</h2>
			  	</div>
				<div class="panel-body">
					@if($currentUser)
						@include('partials.forms.comment',['object'=>$study])	
					@endif
					
					@if ($study->comments->isEmpty())
						<p><em class="text-muted">No comments, yet.</em></p>
					@else	
						@include('partials.comments',['commentable'=> $study])
					@endif
				</div>
			</div>
		</div>	
	</div>

@stop

@section('scripts')
	<script type='text/javascript'>
	/* <![CDATA[ */
	var screenReaderText = {"expand":"<span class=\"screen-reader-text\">expand child menu<\/span>","collapse":"<span class=\"screen-reader-text\">collapse child menu<\/span>"};
	/* ]]> */
	</script>
	<script type='text/javascript' src='wp_theme_twentyfifteen__.js'></script>
@stop