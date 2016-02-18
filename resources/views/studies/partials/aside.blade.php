<?php
	$colors = ['blueBG','greenBG','blueBG','greenBG','blueBG','greenBG','blueBG','greenBG','blueBG','greenBG','blueBG','greenBG'];
	$counter = 0;
?>
				<div id="sidebar-collapse" class="collapse">
				
				<?php $bgColor = $colors[$counter]; $counter++; ?>
				
					<div class="sidebar-block {{$bgColor}}">
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
					
					<?php $bgColor = $colors[$counter]; $counter++; ?>
					<div class="sidebar-block {{$bgColor}}">
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
						<?php $bgColor = $colors[$counter]; $counter++; ?>
						<div class="sidebar-block {{$bgColor}}">
					    	<h2 class="">Media</h2>
							@foreach ($study->recordings AS $recording)
								@include('recordings.partials.recordings-stream-minimal',['recording'=>$recording])
							@endforeach
						</div>
					
					@endif
		
					@if($study->tags->count() >= 1)
						<?php $bgColor = $colors[$counter]; $counter++; ?>
						<div class="sidebar-block {{$bgColor}}">
							<h2>Tags</h2>
							<p> 
							@foreach($study->tags AS $tag)
								<a href="/tag/{!! $tag->name!!}">{!! $tag->name !!}</a>
							@endforeach
							</p>
						</div>
					@endif
						<?php $bgColor = $colors[$counter]; $counter++; ?>
						<div class="sidebar-block {{$bgColor}}">
						
						<h2>Outline</h2>
						<!-- Consider this jquery function for adding an active state in the navigation when scrolling article
							http://stanhub.com/sticky-header-change-navigation-active-class-on-page-scroll-with-jquery/
						-->
						{!! $study->outline !!}
						</div>
						
						@if(count($study->courses) !== 0)

						<?php $bgColor = $colors[$counter]; $counter++; ?>
						<div class="sidebar-block {{$bgColor}}">
							@if(count($study->courses) === 1)
								<h2>Course</h2>
							@elseif(count($study->courses) > 1)
								<h2>Courses</h2>
							@endif
							
							@foreach($study->courses AS $course)
								<a href="{{$course->url()}}">{!! $course->title !!}</a>
							@endforeach	
						</div>
						@endif	
						
						<?php /*
						@if(isset($recent_chapters) && $recent_chapters !== null && is_array($recent_chapters))
						
							<?php $bgColor = $colors[$counter]; $counter++;?>
							<div class="sidebar-block {{$bgColor}}">
								<h2>Scripture</h2>
								
								@foreach($recent_chapters AS $chapter)
								
								
									<a href="{!! $chapter->studyUrl($study) !!}">{!! $chapter->reference !!}</a>
								@endforeach
								
							</div>
						
						@endif
						*/ ?>
						
						<?php $bgColor = $colors[$counter]; $counter++;?>
						<div class="sidebar-block {{$bgColor}}">
							<h2>Scripture</h2>
							
							@if(isset($_GET['bible']))
							<a href="{!! $study->url() !!}">close</a>
							@endif
							
							@if($study->mainVerse !== null)
							<a href="{!! $study->mainVerse->chapter->studyUrl($study) !!}">{!! $study->mainVerse->reference !!}</a>
							@endif
						</div>
						
				</div><!--End sidebar-collapse-->