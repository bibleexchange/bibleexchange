<div>
	
	
	@if(Request::is('user*'))
		<?php $editor = 'editor';?>
	@else
		<?php $editor = '';?>
	@endif
	
	<div class="h1-box">
	
		<h1 class="{!!$editor!!}" id="{{$study->present()->urlTitle}}">
			
		@if( isset($creating))<small>begin a study titled:</small><br><br> @endif
		{!! $page->title !!}
			<div class="center">
				<small><!--  subtitle --></small>
			</div>
		</h1>
	
		<div class="h1-underline"></div>
		<div class="h1-underline"></div>
		<div class="h1-underline"></div>
		
	</div>	

</div>